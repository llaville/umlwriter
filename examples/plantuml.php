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
$generatorPrefix = $generator->getName() .'.';

$renderer = new ClassDiagramRenderer();
$options = [
    $generatorPrefix . 'graph.rankdir' => 'LR',
    $generatorPrefix . 'graph.bgcolor' => 'transparent',
    $generatorPrefix . 'node.fillcolor' => 'lightgrey',
    // @link https://graphviz.gitlab.io/_pages/doc/info/colors.html
    $generatorPrefix . 'subgraph.cluster_0.graph.bgcolor' => 'lightblue',
    $generatorPrefix . 'subgraph.cluster_1.graph.bgcolor' => 'lightblue',
    $generatorPrefix . 'subgraph.cluster_2.graph.bgcolor' => 'lightblue',
    $generatorPrefix . 'subgraph.cluster_3.graph.bgcolor' => 'limegreen',
    $generatorPrefix . 'subgraph.cluster_4.graph.bgcolor' => 'limegreen',
];
// generates UML class diagram of all objects found in dataSource (in PlantUML format)
$script = $renderer($finder, $generator, $options);
// show UML diagram statements
echo $script;

// default format is PNG
echo $generator->createImageFile($renderer->getGraph()) . ' file generated' . PHP_EOL;
