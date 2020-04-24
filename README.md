# UmlWriter

**CAUTION** Major rewrite 2.0 is still in beta stage. For a stable version, check [branch 1.3](https://github.com/llaville/umlwriter/tree/1.3)  

**UmlWriter** is a library that adds the ability to generate UML class diagrams.

- **2.0.0-beta.1** only accept GraphViz backend for image/statement generation.

Source code is analysed by this [parser Reflection API](https://github.com/goaop/parser-reflection)

## Features

The main features provided by this library are:

* build UML statements of a class diagram
* draw png/svg image formats

## Installation

The recommended way to install this library is [through composer](http://getcomposer.org). 
If you don't know yet what is composer, have a look [on introduction](http://getcomposer.org/doc/00-intro.md).

```bash
composer require bartlett/umlwriter
```

## Quick Start

Once [installed](#installation), you can use the following code to draw an UML class
diagram for your existing source code (single php file or folder):

```php
<?php

use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;
use Symfony\Component\Finder\Finder;

// path to directory where to find PHP source code
$dataSource = dirname(__DIR__) . '/src';

$finder = new Finder();
$finder->in($dataSource)->name('*.php');

// use GraphViz as back-end generator
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

## Usage

This library includes a console CLI version with only one command: `diagram:class`

```bash
bin/umlwriter diagram:class src/ --generator graphviz
```

**NOTE** use verbose level 1 or 2 for more details.

## Documentation

Will come soon !

## Authors

* Laurent Laville

## Credits

[bartlett/graph-uml](https://github.com/llaville/graph-uml) is a refactored version (with more features) of [clue/graph-uml](https://github.com/clue/graph-uml) project, licensed under MIT.

## License

This library is licensed under the BSD-3-clauses License - see the `LICENSE` file for details
