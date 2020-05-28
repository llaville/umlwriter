[TOC]
In this example we need a custom autoloader to load non-standard classes.

```php
// autoloader/classmap.php

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require dirname(__DIR__, 2) . '/vendor/autoload.php';
$loader->addClassMap(
    [
        'Name\\Space\\Foo' => __DIR__ . '/reflection-properties.php',
        'Name\\Space\\Bar' => __DIR__ . '/reflection-properties.php',
    ]
);
```

Our data source is only one file: `reflection-properties.php` with such contents

```php
namespace Name\Space;

class Bar
{
    protected $inheritedProperty = 'inheritedDefault';
}

class Foo extends Bar
{
    public $property = 'propertyDefault';
    private $privateProperty = 'privatePropertyDefault';
    public static $staticProperty = 'staticProperty';
    public $defaultlessProperty;
    protected static $defaultName;
}
```

## Console Command

When you're in project folder, invoke `diagram:class` command with following arguments:

```bash
bin/umlwriter diagram:class diagram:class examples/autoloader/reflection-properties.php --bootstrap examples/autoloader/classmap.php
```

Will output this [graph statements](./03_Custom_autoloader.gv) and image look like

![Example](./03_Custom_autoloader.svg)

## Batch PHP

Produces same results as previous console command.

```php
require_once 'autoloader/classmap.php';

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

// default format is PNG
echo $generator->createImageFile($renderer->getGraph()) . ' file generated' . PHP_EOL;
```
