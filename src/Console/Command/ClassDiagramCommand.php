<?php
declare(strict_types=1);

namespace Bartlett\UmlWriter\Console\Command;

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
            ->addArgument('paths', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Data source (file or directory)')
            ->addOption('generator', null, InputOption::VALUE_REQUIRED, 'Graph generator')
            ->addOption('bootstrap', null, InputOption::VALUE_REQUIRED, 'A PHP script that is included before graph run')
            ->addOption('configuration', 'c', InputOption::VALUE_REQUIRED, 'Read configuration from YAML file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $configFilename = $input->getOption('configuration');
        $configHandler = new ConfigurationHandler($configFilename);
        try {
            $parameters = $configHandler->toFlat();
            $configFrom = $configHandler->filename() ?? 'Default values';
        } catch (InvalidArgumentException $exception) {
            $io->caution($exception->getMessage());
            $parameters = [];
        }

        $bootstrap = $input->getOption('bootstrap');
        if (!empty($bootstrap)) {
            includeFile($bootstrap);
        }

        $paths = $input->getArgument('paths');

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

        $graphGenerator = $input->getOption('generator');
        if (!$graphGenerator) {
            $io->caution('Not enough arguments (missing --generator option)');
            return 1;
        }

        $generator = $this->generatorFactory->createInstance($graphGenerator)->getGenerator();

        $io->title('UML Class Diagram Generation');
        $io->definitionList(
            ['Path(s)' => implode(', ', $paths)],
            ['Generator' => $graphGenerator],
            ['Configuration' => $configFrom ?? '']
        );

        $script = $this->renderer->__invoke($finder, $generator, $parameters);

        if ($output->isVerbose()) {
            $io->section('Configuration');

            $io->definitionList(
                ['Parameters' => count($parameters ?? [])]
            );
            if ($output->isVeryVerbose()) {
                $io->horizontalTable(
                    array_keys($parameters),
                    [array_values($parameters)]
                );
            }

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

        $io->section('Graph statements');
        $io->writeln($script);

        $io->success('UML classes were generated.');
        return 0;
    }
}
