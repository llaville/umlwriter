<?php declare(strict_types=1);

require_once __DIR__ . '/classmap.php';

use Bartlett\GraphUml\Generator\GraphVizGenerator;
use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;

use Name\Space\MyGeneratorFactory;

use Symfony\Component\Finder\Finder;

// path to directory where to find PHP source code
$dataSource = dirname(__DIR__, 2) . '/src';

$finder = new Finder();
$finder->in($dataSource)->name('*.php');

$generatorFactory = new MyGeneratorFactory('mygenerator');
// creates instance of Name\Space\MyGenerator
$generator = $generatorFactory->getGenerator();

$renderer = new ClassDiagramRenderer();
// generates UML class diagram of all objects found in dataSource
$script = $renderer($finder, $generator);
// show UML diagram statements
echo $script;


$finder = new Finder();
$finder->in(__DIR__)->name('*.php')->notName('graphviz.php');

$generatorFactory = new GeneratorFactory('graphviz');

// creates instance of Bartlett\GraphUml\Generator\GraphVizGenerator
/** @var GraphVizGenerator $generator */
$generator = $generatorFactory->getGenerator();

$renderer = new ClassDiagramRenderer();
$options = [
    'show_private' => false,
    'show_protected' => false,
    'node.fillcolor' => '#FEFECE',
    'node.style' => 'filled',
];
// generates UML class diagram of all objects found in dataSource (in graphviz format)
$renderer($finder, $generator, $options);

// default format is PNG, change it to SVG
$generator->setFormat('svg');

if (isset($argv[1])) {
    // target folder provided
    $cmdFormat = '%E -T%F %t -o ' . rtrim($argv[1], DIRECTORY_SEPARATOR) . '/generator.graphviz.%F';
} else {
    $cmdFormat = '';
}
$graph = $renderer->getGraph();
$target = $generator->createImageFile($graph, $cmdFormat);
echo (empty($target) ? 'no' : $target) . ' file generated' . PHP_EOL;
