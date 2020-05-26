<?php
declare(strict_types=1);

namespace Bartlett\UmlWriter\Console\Command;

use Bartlett\GraphUml\Generator\GeneratorInterface;
use Bartlett\UmlWriter\Generator\GeneratorFactoryInterface;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;
use Bartlett\UmlWriter\Service\ConfigurationHandler;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

use InvalidArgumentException;
use function Composer\Autoload\includeFile;

class ClassDiagramCommand extends Command
{
    public const NAME = 'diagram:class';

    protected static $defaultName = self::NAME;

    /** @var ClassDiagramRenderer  */
    private $renderer;

    /** @var GeneratorFactoryInterface  */
    private $generatorFactory;

    public function __construct(
        ClassDiagramRenderer $renderer,
        GeneratorFactoryInterface $generatorFactory
    ) {
        parent::__construct();
        $this->renderer = $renderer;
        $this->generatorFactory = $generatorFactory;
    }

    protected function configure()
    {
        $this
            ->setDescription('Generate class diagram statements of a given data source')
            ->addArgument('paths', InputArgument::IS_ARRAY, 'Data source (file or directory)')
            ->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Path to output image file')
            ->addOption('format', '', InputOption::VALUE_REQUIRED, 'Set output format (depending of each generator)')
            ->addOption('generator', null, InputOption::VALUE_REQUIRED, 'Graph generator')
            ->addOption('bootstrap', null, InputOption::VALUE_REQUIRED, 'A PHP script that is included before graph run')
            ->addOption('configuration', 'c', InputOption::VALUE_REQUIRED, 'Read configuration from YAML file')
            ->addOption('without-constants', '', InputOption::VALUE_NONE, 'Hide all class constants')
            ->addOption('without-properties', '', InputOption::VALUE_NONE, 'Hide all class properties')
            ->addOption('without-methods', '', InputOption::VALUE_NONE, 'Hide all class methods')
            ->addOption('hide-private', '', InputOption::VALUE_NONE, 'Hide private methods/properties')
            ->addOption('hide-protected', '', InputOption::VALUE_NONE, 'Hide protected methods/properties')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $parameters = $this->handleConfiguration($input, $io);

        if (empty($parameters['generator'])) {
            $io->caution('Not enough arguments (missing --generator option)');
            return 1;
        }

        $paths = array_filter($parameters, function($key) {
            return strpos($key, 'paths.') === 0;
        },ARRAY_FILTER_USE_KEY);

        if (empty($paths)) {
            $io->caution('Not enough arguments (missing data source paths)');
            return 1;
        }

        $finder = $this->handleSourceLocator($paths);

        $generator = $this->generatorFactory->createInstance($parameters['generator'])->getGenerator();

        $io->title('UML Class Diagram Generation');
        $io->definitionList(
            ['Path(s)' => implode(', ', $paths)],
            ['Generator' => $parameters['generator']],
            ['Configuration' => $parameters['__from'] ?? '']
        );
        unset($parameters['__from']);

        $script = $this->renderer->__invoke($finder, $generator, $parameters);

        if ($output->isVerbose()) {
            $this->handleContext($output, $io, $parameters);
        }

        $exitCode = $this->handleOutput($generator, $input->getOption('output'), $input->getOption('format'), $io);

        if (0 === $exitCode) {
            $io->section('Graph statements');
            $io->writeln($script);

            $io->success('UML classes were generated.');
        }
        return $exitCode;
    }

    private function handleContext($output, $io, $parameters): void
    {
        $io->section('Configuration');

        array_walk($parameters, function(&$value, $key) {
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

    private function handleOutput(GeneratorInterface $generator, ?string $target, ?string $format, $io): int
    {
        if (null === $target && null === $format) {
            // do not generate image file
            return 0;
        }

        if ($target !== null) {
            if (is_dir($target)) {
                $target = rtrim($target, '/') . '/umlwriter.svg';
            }

            $filename = basename($target);
            $pos = strrpos($filename, '.');
            if ($pos !== false && isset($filename[$pos + 1])) {
                // extension found and not empty
                $generator->setFormat(substr($filename, $pos + 1));;
            }
        }

        if ($format !== null) {
            $generator->setFormat($format);
        }

        $path = $generator->createImageFile($this->renderer->getGraph(), '');

        if ($target !== null) {
            if (!@rename($path, $target)) {
                $io->error(sprintf('Cannot write diagram into %s', $target));
                return 1;
            }
            $path = realpath($target);
        }
        $io->note(sprintf('Image built into %s', $path));

        return 0;
    }

    private function handleConfiguration($input, $io): array
    {
        $configFilename = $input->getOption('configuration');
        $configHandler = new ConfigurationHandler($configFilename);

        try {
            $parameters = $configHandler->toFlat();
            $parameters['__from'] = $configHandler->filename() ?? 'Default values and/or command line arguments';

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
            includeFile($bootstrap);
        }

        $parameters['generator'] = $input->getOption('generator') ?? $parameters['generator'] ?? '';

        $paths = $input->getArgument('paths');
        foreach ($paths as $index => $path) {
            $parameters['paths.'.$index] = $path;
        }

        return $parameters;
    }

    private function handleSourceLocator(array $paths): Finder
    {
        $finder = new Finder();
        $finder->files();

        foreach ($paths as $path) {
            if (is_dir($path)) {
                $finder->in($path);
                $finder->name('*.php');
            } else {
                $finder->in(dirname($path));
                $finder->name(basename($path));
            }
        }

        return $finder;
    }
}
