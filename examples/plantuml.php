<?php
/**
 * Examples of PlantUML UML class diagrams
 *
 * @link https://plantuml.com/
 * @author Laurent Laville
 */

$example = $_SERVER['argv'][1] ?? null;
$format = $_SERVER['argv'][2] ?? 'svg';
$printGraphStatement = $_SERVER['argv'][3] ?? false;

$baseDir = __DIR__ . DIRECTORY_SEPARATOR . $example . DIRECTORY_SEPARATOR;
$available = is_dir($baseDir) && file_exists($baseDir);

if (empty($example) || !$available) {
    throw new RuntimeException(sprintf('Example "%s" does not exists.', $example));
}

use Bartlett\GraphPlantUml\PlantUmlGenerator;
use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;

$resources = [
    $baseDir . 'bootstrap.php',     // autoloader or any other resource to include before run this script
    $baseDir . 'datasource.php',    // list of files or classes to parse
    $baseDir . 'options.php',       // all options to customize the Graph
];

foreach ($resources as $resource) {
    if (file_exists($resource)) {
        $variable = basename($resource, '.php');
        $$variable = require $resource;
    }
}

if (isset($bootstrap)) {
    $bootstrap();
}

$generatorName = basename(__FILE__, '.php');

$generatorFactory = new GeneratorFactory($generatorName);
/** @var PlantUmlGenerator $generator */
$generator = $generatorFactory->getGenerator();
$generator->setExecutable(dirname(__DIR__) . '/vendor/bin/plantuml');

$renderer = new ClassDiagramRenderer();
// generates UML class diagram of all objects found in dataSource (in graphviz format)
$graph = $renderer($datasource(), $generator, $options);
// show UML diagram statements
if ($printGraphStatement) {
    $script = $generator->createScript($graph);
    echo $script;
}

// default format is PNG, change it to SVG
$generator->setFormat($format);

$target = $generator->createImageFile($graph);
echo (empty($target) ? 'no' : $target) . ' file generated' . PHP_EOL;
