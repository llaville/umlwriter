<!-- markdownlint-disable MD013 -->
# Programmatically

Repository contains an `examples` directory that have many use cases to generate either `Graphviz` or `PlantUML` format.

Here is a basic example, that you may follow to produce your own UML diagram
from any source code that is loadable with an autoloader :

```php
<?php
use Bartlett\GraphUml\Generator\GraphVizGenerator;
use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;

// your autoloader, that should include/load UmlWriter source code
require_once 'vendor/autoload.php';

// Depending on the generator you will use,
$generatorId = 'graphviz';

// Identify the format of image to build
$format = 'svg';

// Identify the datasource to analyse
// (maybe a Symfony Finder instance, or another iterator such as a PHP Generator)
$datasource = function (): Generator
{
    $classes = [
        GeneratorFactory::class,
        GraphVizGenerator::class,
    ];
    foreach ($classes as $class) {
        yield $class;
    }
};

// Customize some render options
$options = [
    'cluster.Bartlett\\GraphUml\\Generator.graph.bgcolor' => 'LightSkyBlue',
    'cluster.Bartlett\\UmlWriter\\Generator.graph.bgcolor' => 'BurlyWood',
];

// Get an instance of the Generator
$generatorFactory = new GeneratorFactory();
/** @var GraphVizGenerator $generator */
$generator = $generatorFactory->createInstance($generatorId, $format);

// Generate UML class diagram of all objects found in dataSource
$renderer = new ClassDiagramRenderer();
/** @var \Graphp\Graph\Graph $graph */
$graph = $renderer($datasource(), $generator, $options);

// You can either :
// - produce the graph statements (depending on the Generator used)
$statements = $generator->createScript($graph);

// - produce the image in format selected
$imagePath = $generator->createImageFile($graph);

var_dump([$imagePath => $statements]);
```
