<?php
/**
 * Examples of PlantUML UML class diagrams
 *
 * PHP version 7
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  https://opensource.org/licenses/BSD-3-Clause  The 3-Clause BSD License
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;
use Symfony\Component\Finder\Finder;

// path to directory where to find PHP source code
$dataSource = dirname(__DIR__) . '/src';

$finder = new Finder();
$finder->in($dataSource)->name('*.php');

$generatorFactory = new GeneratorFactory('plantuml');
// creates instance of Bartlett\GraphPlantUml\PlantUmlGenerator
$generator = $generatorFactory->getGenerator();
$generator->setExecutable(dirname(__DIR__) . '/vendor/bin/plantuml');

$renderer = new ClassDiagramRenderer();
$options = [
    'show_private' => false,
    'show_protected' => false,
    'graph.rankdir' => 'LR',
    'graph.bgcolor' => 'transparent',
    'node.fillcolor' => 'lightgrey',
    'node.style' => 'filled',
    // @link https://plantuml.com/en/color
    'cluster.Psr\\Container.graph.bgcolor' => 'LimeGreen',
    'cluster.Symfony\\Component\\Console.graph.bgcolor' => 'LightSkyBlue',
    'cluster.Symfony\\Component\\Console\\Command.graph.bgcolor' => 'LightSkyBlue',
    'cluster.Symfony\\Component\\Config\\Loader.graph.bgcolor' => 'LightSkyBlue',
    'cluster.Symfony\\Contracts\\Service.graph.bgcolor' => 'LightSkyBlue',
    'cluster.Bartlett\\UmlWriter\\Service.graph.bgcolor' => 'BurlyWood',
    'cluster.Bartlett\\UmlWriter\\Console.graph.bgcolor' => 'BurlyWood',
    'cluster.Bartlett\\UmlWriter\\Console\\Command.graph.bgcolor' => 'BurlyWood',
    'cluster.Bartlett\\UmlWriter\\Config\\Loader.graph.bgcolor' => 'BurlyWood',
    'cluster.Bartlett\\UmlWriter\\Generator.graph.bgcolor' => 'BurlyWood',
];
// generates UML class diagram of all objects found in dataSource (in PlantUML format)
$script = $renderer($finder, $generator, $options);
// show UML diagram statements
echo $script;

// default format is PNG
echo $generator->createImageFile($renderer->getGraph()) . ' file generated' . PHP_EOL;  // @phpstan-ignore-line
