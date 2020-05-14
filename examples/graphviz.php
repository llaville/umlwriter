<?php
/**
 * Examples of Graphviz UML class diagrams
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

$generatorFactory = new GeneratorFactory('graphviz');
// creates instance of Bartlett\GraphUml\Generator\GraphVizGenerator
$generator = $generatorFactory->getGenerator();
$generatorPrefix = $generator->getName() .'.';

$renderer = new ClassDiagramRenderer();
$options = [
    $generatorPrefix . 'graph.rankdir' => 'LR',
    $generatorPrefix . 'graph.bgcolor' => 'transparent',
    $generatorPrefix . 'node.fillcolor' => 'lightgrey',
    $generatorPrefix . 'node.style' => 'filled',
    // @link https://plantuml.com/en/color
    $generatorPrefix . 'cluster.Psr\\Container.graph.bgcolor' => 'LimeGreen',
    $generatorPrefix . 'cluster.Symfony\\Component\\Console.graph.bgcolor' => 'LightSkyBlue',
    $generatorPrefix . 'cluster.Symfony\\Component\\Console\\Command.graph.bgcolor' => 'LightSkyBlue',
    $generatorPrefix . 'cluster.Symfony\\Component\\Config\\Loader.graph.bgcolor' => 'LightSkyBlue',
    $generatorPrefix . 'cluster.Symfony\\Contracts\\Service.graph.bgcolor' => 'LightSkyBlue',
    $generatorPrefix . 'cluster.Bartlett\\UmlWriter\\Service.graph.bgcolor' => 'LawnGreen',
    $generatorPrefix . 'cluster.Bartlett\\UmlWriter\\Console.graph.bgcolor' => 'LawnGreen',
    $generatorPrefix . 'cluster.Bartlett\\UmlWriter\\Console\\Command.graph.bgcolor' => 'LawnGreen',
    $generatorPrefix . 'cluster.Bartlett\\UmlWriter\\Config\\Loader.graph.bgcolor' => 'LawnGreen',
    $generatorPrefix . 'cluster.Bartlett\\UmlWriter\\Generator.graph.bgcolor' => 'LawnGreen',
];
// generates UML class diagram of all objects found in dataSource (in graphviz format)
$script = $renderer($finder, $generator, $options);
// show UML diagram statements
echo $script;

// default format is PNG
echo $generator->createImageFile($renderer->getGraph()) . ' file generated' . PHP_EOL;
