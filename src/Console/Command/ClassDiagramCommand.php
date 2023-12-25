<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\UmlWriter\Console\Command;

use Bartlett\GraphUml\Generator\GeneratorInterface;
use Bartlett\UmlWriter\Generator\GeneratorFactoryInterface;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;
use Bartlett\UmlWriter\Service\ConfigurationHandler;

use Graphp\Graph\Graph;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

use InvalidArgumentException;
use ReflectionException;
use SplFileInfo;
use Throwable;
use function array_filter;
use function array_keys;
use function array_values;
use function array_walk;
use function count;
use function file_exists;
use function implode;
use function is_bool;
use function is_dir;
use function realpath;
use function rename;
use function rtrim;
use function sprintf;
use function str_starts_with;
use function var_export;
use const ARRAY_FILTER_USE_KEY;

/**
 * @author Laurent Laville
 */
#[AsCommand(name: 'diagram:class')]
final class ClassDiagramCommand extends Command
{
    public function __construct(
        private readonly ClassDiagramRenderer $renderer,
        private readonly GeneratorFactoryInterface $generatorFactory,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Generate class diagram statements of a given data source')
            ->addArgument('paths', InputArgument::IS_ARRAY, 'Data source (file or directory)')
            ->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Path to output image file')
            ->addOption('format', '', InputOption::VALUE_REQUIRED, 'Set output format (depending of each generator)')
            ->addOption('generator', null, InputOption::VALUE_REQUIRED, 'Graph generator')
            ->addOption('executable', null, InputOption::VALUE_REQUIRED, 'Generator external binary resource')
            ->addOption('bootstrap', null, InputOption::VALUE_REQUIRED, 'A PHP script that is included before graph run')
            ->addOption('configuration', 'c', InputOption::VALUE_REQUIRED, 'Read configuration from YAML file')
            ->addOption('without-constants', '', InputOption::VALUE_NONE, 'Hide all class constants')
            ->addOption('without-properties', '', InputOption::VALUE_NONE, 'Hide all class properties')
            ->addOption('without-methods', '', InputOption::VALUE_NONE, 'Hide all class methods')
            ->addOption('hide-private', '', InputOption::VALUE_NONE, 'Hide private methods/properties')
            ->addOption('hide-protected', '', InputOption::VALUE_NONE, 'Hide protected methods/properties')
            ->addOption('no-statement', '', InputOption::VALUE_NONE, 'Do not show diagram statements')
        ;
    }

    /**
     * @throws ReflectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $parameters = $this->handleConfiguration($input, $io);

        $paths = array_filter($parameters, function ($key) {
            return str_starts_with($key, 'paths.');
        }, ARRAY_FILTER_USE_KEY);

        if (empty($paths)) {
            $io->caution('Not enough arguments (missing data source paths)');
            return 1;
        }

        try {
            $generator = $this->generatorFactory->createInstance(
                $parameters['generator'],
                $parameters['format'],
                $parameters['executable']
            );
        } catch (Throwable $e) {
            $io->error($e->getMessage());
            return 1;
        }

        $finder = $this->handleSourceLocator($paths);

        $io->title('UML Class Diagram Generation');
        $io->definitionList(
            ['Path(s)' => implode(', ', $paths)],
            ['Generator' => $parameters['generator']],
            ['Configuration' => $parameters['__from'] ?? '']
        );
        unset($parameters['__from']);

        $graph = $this->renderer->__invoke($finder, $generator, $parameters);
        $script = $generator->createScript($graph);

        if ($output->isVerbose()) {
            $this->handleContext($output, $io, $parameters);
        }

        $exitCode = $this->handleOutput($graph, $generator, $input->getOption('output'), $parameters['format'], $io);

        if (0 === $exitCode) {
            if (!$input->getOption('no-statement')) {
                $io->section('Graph statements');
                $io->writeln($script);
            }
            $io->success('UML classes were generated.');
        }
        return $exitCode;
    }

    /**
     * @param array<string, mixed> $parameters
     */
    private function handleContext(OutputInterface $output, SymfonyStyle $io, array $parameters): void
    {
        $io->section('Configuration');

        array_walk($parameters, function (&$value, $key) {
            if (is_bool($value)) {
                $value = var_export($value, true);
            }
        });
        $io->horizontalTable(
            array_keys($parameters),
            [array_values($parameters)]
        );

        $io->section('Entities summary');

        $metaData = $this->renderer->getMetadata();
        $io->definitionList(
            ['classes' => count($metaData['classes'])]
        );
        if ($output->isVeryVerbose()) {
            $io->comment($metaData['classes']);
        }
        $io->definitionList(
            ['interfaces' => count($metaData['interfaces'])]
        );
        if ($output->isVeryVerbose()) {
            $io->comment($metaData['interfaces']);
        }
        $io->definitionList(
            ['namespaces' => count($metaData['namespaces'])]
        );
        if ($output->isVeryVerbose()) {
            $io->comment($metaData['namespaces']);
        }
    }

    private function handleOutput(Graph $graph, GeneratorInterface $generator, ?string $target, ?string $format, SymfonyStyle $io): int
    {
        if (null === $target && null === $format) {
            // do not generate image file
            return 0;
        }

        $path = $generator->createImageFile($graph, '');

        if ($target !== null) {
            if (is_dir($target)) {
                $target = rtrim($target, '/') . '/umlwriter.' . $format;
            }
            if (!@rename($path, $target)) {
                $io->error(sprintf('Cannot write diagram into %s', $target));
                return 1;
            }
            $path = realpath($target);
        }
        $io->note(sprintf('Image built into %s', $path));

        return 0;
    }

    /**
     * @return array<string, mixed>
     */
    private function handleConfiguration(InputInterface $input, SymfonyStyle $io): array
    {
        $configFilename = $input->getOption('configuration');
        $configHandler = new ConfigurationHandler($configFilename);

        try {
            $parameters = $configHandler->toFlat();
            $parameters['__from'] = $configFilename ?? 'Default values and/or command line arguments';

            if ($input->getOption('without-constants')) {
                $parameters['show_constants'] = false;
            }
            if ($input->getOption('without-properties')) {
                $parameters['show_properties'] = false;
            }
            if ($input->getOption('without-methods')) {
                $parameters['show_methods'] = false;
            }
            if ($input->getOption('hide-private')) {
                $parameters['show_private'] = false;
            }
            if ($input->getOption('hide-protected')) {
                $parameters['show_protected'] = false;
            }
        } catch (InvalidArgumentException $exception) {
            $io->caution($exception->getMessage());
            $parameters = [];
        }

        $bootstrap = $input->getOption('bootstrap');
        if (!empty($bootstrap)) {
            $parameters['bootstrap'] = $bootstrap;
            if (file_exists($bootstrap)) {
                include $bootstrap;
            }
        }

        $parameters['generator'] = $input->getOption('generator') ?? $parameters['generator'] ?? 'graphviz';
        $parameters['executable'] = $input->getOption('executable') ?? $parameters['executable'] ?? 'dot';
        $parameters['format'] = $input->getOption('format') ?? $parameters['format'] ?? 'svg';

        $paths = $input->getArgument('paths');
        foreach ($paths as $index => $path) {
            $parameters['paths.' . $index] = $path;
        }

        return $parameters;
    }

    /**
     * @param string[] $paths
     */
    private function handleSourceLocator(array $paths): Finder
    {
        $filter = function (SplFileInfo $file) use ($paths) {
            foreach ($paths as $path) {
                if (is_dir($path)) {
                    if (str_starts_with($file->getPath(), rtrim($path, '/'))) {
                        return true;
                    }
                } else {
                    if ($file->getPathname() === $path) {
                        return true;
                    }
                }
            }
            return false;
        };

        $finder = new Finder();
        $finder->files();
        $finder->name('*.php');

        foreach ($paths as $path) {
            if (is_dir($path)) {
                $finder->in($path);
            } else {
                $finder->in(dirname($path));
            }
        }
        $finder->filter($filter);

        return $finder;
    }
}
