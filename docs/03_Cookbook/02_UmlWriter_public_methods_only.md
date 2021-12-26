<!-- markdownlint-disable MD013 -->
# Architecture Diagram (public visibility)

Generate UmlWriter graph architecture with only public methods and default render options.

## Console Command

When you're in project folder, invoke `diagram:class` command with following arguments:

```bash
bin/umlwriter diagram:class src/ --hide-private --hide-protected --without-constants --without-properties --format=svg
```

Will output this [graph statements](./02_UmlWriter_public_methods_only.gv) and image look like

![Example](./public_methods_only.graphviz.svg)

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

$generatorFactory = new GeneratorFactory('graphviz');
// creates instance of Bartlett\GraphUml\Generator\GraphVizGenerator
$generator = $generatorFactory->getGenerator();

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
$script = $renderer($finder, $generator, $options);
// show UML diagram statements
echo $script;

// default format is PNG, change it to SVG
$generator->setFormat('svg');

echo $generator->createImageFile($renderer->getGraph()) . ' file generated' . PHP_EOL;
```
