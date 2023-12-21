<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @since Release 3.0.0
 * @author Laurent Laville
 */

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Bartlett\GraphUml\Generator\GraphVizGenerator;
use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;

$script = $_SERVER['argv'][1] ?? null;

if (!$script) {
    throw new LogicException("Unable to build a graph UML for unknown script.");
}
$script = basename($script, '.php');

$baseDir = __DIR__ . DIRECTORY_SEPARATOR . $script . DIRECTORY_SEPARATOR;

$resources = [
    $baseDir . 'datasource.php',    // list of files or classes to parse
    $baseDir . 'options.php',       // all options to customize the Graph
];

foreach ($resources as $resource) {
    if (file_exists($resource)) {
        $variable = basename($resource, '.php');
        $$variable = require $resource;
    }
}

$generatorFactory = new GeneratorFactory('graphviz');
/** @var GraphVizGenerator $generator */
$generator = $generatorFactory->getGenerator();

$renderer = new ClassDiagramRenderer();
// generates UML class diagram of all objects found in dataSource (in graphviz format)
$graph = $renderer($datasource(), $generator, $options);

// writes graphviz statements to file
$folder = $_SERVER['argv'][2] ?? null;
$output = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $script . '.html.gv';
file_put_contents($output, $generator->createScript($graph));

// default format is PNG, change it to SVG
$generator->setFormat($format = 'svg');

if (isset($folder)) {
    $output = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $script . '.graphviz.' . $format;
    $cmdFormat = '%E -T%F %t -o ' . $output;
} else {
    $cmdFormat = '';
}
$target = $generator->createImageFile($graph, $cmdFormat);
echo (empty($target) ? 'no' : $target) . ' file generated' . PHP_EOL;
