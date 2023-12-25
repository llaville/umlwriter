<!-- markdownlint-disable MD013 -->
# Architecture Diagram (public visibility)

Generate UmlWriter graph architecture with only public methods and default render options.

## Console Command

When you're in project folder, invoke `diagram:class` command with following arguments:

```bash
bin/umlwriter diagram:class src/ --hide-private --hide-protected --without-constants --without-properties --format=svg
```

Will output this [graph statements](../assets/images/public-methods-only.html.gv) and image look like

![Graph UML Example](../assets/images/public-methods-only.graphviz.svg)

## Batch PHP

Produces same results as previous console command.

```php
<?php
use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;

use Symfony\Component\Finder\Finder;

// path to directory where to find PHP source code
$dataSource = dirname(__DIR__, 2) . '/src';

$finder = new Finder();
$finder->in($dataSource)->name('*.php');

$generatorFactory = new GeneratorFactory();
// creates instance of Bartlett\GraphUml\Generator\GraphVizGenerator
$generator = $generatorFactory->createInstance('graphviz');

$renderer = new ClassDiagramRenderer();
$options = [
    'show_private' => false,
    'show_protected' => false,
    'show_constants' => false,
    'show_properties' => false,
    'node.fillcolor' => '#FEFECE',
    'node.style' => 'filled',
];
// generates UML class diagram of all objects found in dataSource (in graphviz format)
$graph = $renderer($finder, $generator, $options);

$target = $generator->createImageFile($graph);
echo (empty($target) ? 'no' : $target) . ' file generated' . PHP_EOL;
```
