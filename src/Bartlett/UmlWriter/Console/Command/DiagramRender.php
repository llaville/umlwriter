<?php
/**
 * The UmlWriter diagram:render command.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  GIT: $Id$
 * @link     http://php5.laurent-laville.org/umlwriter/
 */

namespace Bartlett\UmlWriter\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Diagram statements generator
 */
class DiagramRender extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName('diagram:render')
            ->setDescription('Generate diagram statements of all objects')
            ->addArgument(
                'source',
                InputArgument::REQUIRED,
                'Path to the data source'
            )
            ->addOption(
                'reflector',
                null,
                InputOption::VALUE_OPTIONAL,
                'Reverse-engine compatible (case insensitive)',
                'reflect'
            )
            ->addOption(
                'processor',
                null,
                InputOption::VALUE_REQUIRED,
                'Diagram processor (case insensitive)'
            )
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // diagram syntax processor
        $proc = trim($input->getOption('processor'));

        $processors = array(
            'plantuml' => '\\Bartlett\\UmlWriter\\Processor\\PlantUMLProcessor',
            'graphviz' => '\\Bartlett\\UmlWriter\\Processor\\GraphvizProcessor',
        );
        if (!array_key_exists(strtolower($proc), $processors)) {
            throw new \InvalidArgumentException(
                sprintf('Diagram syntax processor "%s" is unknown.', $proc)
            );
        }
        $proc = strtolower($proc);

        // reverse-engine compatible solution
        $engine = trim($input->getOption('reflector'));

        $engines = array(
            'reflect'         => '\\Bartlett\\UmlWriter\\Reflector\\Reflect',
            'tokenreflection' => '\\Bartlett\\UmlWriter\\Reflector\\TokenReflection',
        );
        if (!array_key_exists(strtolower($engine), $engines)) {
            throw new \InvalidArgumentException(
                sprintf('Reverse-engine compatible solution "%s" is unknown.', $engine)
            );
        }
        $engine = strtolower($engine);

        $dataSource = trim($input->getArgument('source'));

        $reflector = new $engines[$engine]($dataSource);
        $processor = new $processors[$proc]($reflector);

        $commandName = explode(':', $this->getName());

        $status = '<info>PASS</info>';

        if (count($commandName) == 2) {
            $graphStmt = $processor->render();
            $output->writeln($graphStmt);

        } elseif ('class' == $commandName[2]) {
            $argument  = trim($input->getArgument('object'));
            $graphStmt = $processor->renderClass($argument);
            $output->writeln($graphStmt);

        } elseif ('namespace' == $commandName[2]) {
            $argument  = trim($input->getArgument('object'));
            $graphStmt = $processor->renderNamespace($argument);
            $output->writeln($graphStmt);

        } else {
            $status = '<error>FAIL</error>';
        }

        if ($output->isVerbose() || strpos($status, 'FAIL') !== false) {
            $message = sprintf('Diagram statements generation %s', $status);
            $output->writeln($message);
        }
    }
}
