<?php declare(strict_types=1);

require_once __DIR__ . '/classmap.php';

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
