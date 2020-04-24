<?php
declare(strict_types=1);

namespace Bartlett\UmlWriter\Console\Command;

use Bartlett\UmlWriter\Generator\GeneratorFactoryInterface;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

class ClassDiagramCommand extends Command
{
    protected static $defaultName = 'diagram:class';

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
            ->addArgument('folder', InputArgument::REQUIRED, 'Data source (file or folder)')
            ->addOption('generator', null, InputOption::VALUE_REQUIRED, 'Graph generator')
            ->addOption('bootstrap', null, InputOption::VALUE_REQUIRED, 'A PHP script that is included before graph run', 'vendor/autoload.php')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        require $input->getOption('bootstrap');

        $io = new SymfonyStyle($input, $output);
        $folder = $input->getArgument('folder');

        $finder = new Finder();
        $finder->files();

        if (is_dir($folder)) {
            $finder->in($folder);
            $finder->name('*.php');
        } else {
            $finder->in(dirname($folder));
            $finder->name(basename($folder));
        }

        $graphGenerator = $input->getOption('generator');
        if (!$graphGenerator) {
            $io->caution('Not enough arguments (missing --generator option)');
            return 1;
        }

        $generator = $this->generatorFactory->createInstance($graphGenerator)->getGenerator();

        $io->title('UML Class Diagram Generation');
        $io->definitionList(
            ['Data source' => realpath($folder)],
            ['Generator' => $graphGenerator]
        );

        $script = $this->renderer->__invoke($finder, $generator);

        if ($output->isVerbose()) {
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
