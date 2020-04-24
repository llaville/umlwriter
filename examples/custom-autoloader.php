<?php
/**
 * Examples of class diagram on sources loaded with custom autoloader
 *
 * PHP version 7
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  https://opensource.org/licenses/BSD-3-Clause  The 3-Clause BSD License
 */

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require_once dirname(__DIR__) . '/vendor/autoload.php';
$loader->addClassMap(
    [
        'Name\\Space\\Foo' => __DIR__ . '/autoloader/reflection-properties.php',
        'Name\\Space\\Bar' => __DIR__ . '/autoloader/reflection-properties.php',
    ]
);

use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;
use Symfony\Component\Finder\Finder;

// path to directory where to find PHP source code
$dataSource = __DIR__ . '/autoloader';

$finder = new Finder();
$finder->in($dataSource)->name('*.php');

$generatorFactory = new GeneratorFactory('graphviz');
// creates instance of Bartlett\GraphUml\Generator\GraphVizGenerator
$generator = $generatorFactory->getGenerator();

$renderer = new ClassDiagramRenderer();
// generates UML class diagram of all objects found in dataSource
$script = $renderer($finder, $generator);
// show UML diagram statements
echo $script;
