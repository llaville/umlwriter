<?php
/**
 * Examples of PlantUML UML class diagrams
 *
 * @link https://plantuml.com/
 * @author Laurent Laville
 */

if ($_SERVER['argc'] == 1) {
    echo '=====================================================================', PHP_EOL;
    echo 'Usage: php examples/plantuml.php <example-dirname>', PHP_EOL;
    echo '                                 <output-folder>', PHP_EOL;
    echo '                                 <format:png|svg>', PHP_EOL;
    echo '                                 <write-statement-to-file>', PHP_EOL;
    echo '=====================================================================', PHP_EOL;
    exit();
}

$example = $_SERVER['argv'][1] ?? null;
$folder = $_SERVER['argv'][2] ?? sys_get_temp_dir();
$format = $_SERVER['argv'][3] ?? 'svg';
$writeGraphStatement = $_SERVER['argv'][4] ?? false;

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

$isAutoloadFound = false;

foreach ($resources as $resource) {
    if (file_exists($resource)) {
        $variable = basename($resource, '.php');
        $$variable = require $resource;
    }
    if (isset($bootstrap) && !$isAutoloadFound) {
        $isAutoloadFound = true;
        $bootstrap();
    }
}

$generatorName = basename(__FILE__, '.php');

$generatorFactory = new GeneratorFactory();
/** @var PlantUmlGenerator $generator */
$generator = $generatorFactory->createInstance($generatorName);

$renderer = new ClassDiagramRenderer();
// generates UML class diagram of all objects found in dataSource (in PlantUML format)
$graph = $renderer($datasource(), $generator, $options);

if ($writeGraphStatement) {
    // writes graphviz statements to file
    $output = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $example . '.puml';
    file_put_contents($output, $generator->createScript($graph));
}

$target = $generator->createImageFile($graph);

$from = $target;
$target = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $example . '.plantuml.' . $format;
if (!rename($from, $target)) {
    $target = null;
}
echo (empty($target) ? 'no' : $target) . ' file generated' . PHP_EOL;
