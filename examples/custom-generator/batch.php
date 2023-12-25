<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Laurent Laville
 * @since Release 4.0.0
 */

use Bartlett\UmlWriter\Service\ClassDiagramRenderer;
use Name\Space\MyGeneratorFactory;
use Symfony\Component\Finder\Finder;

$bootstrap = require __DIR__ . '/bootstrap.php';
$bootstrap();

// path to directory where to find PHP source code
$dataSource = dirname(__DIR__, 2) . '/src';

$finder = new Finder();
$finder->in($dataSource)->name('*.php');

$generatorFactory = new MyGeneratorFactory();
// creates instance of Name\Space\MyGenerator
$generator = $generatorFactory->createInstance('mygenerator');

$renderer = new ClassDiagramRenderer();
// generates UML class diagram of all objects found in dataSource
$graph = $renderer($finder, $generator);

$script = $generator->createScript($graph);

echo $script, PHP_EOL;
