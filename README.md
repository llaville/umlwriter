[![Latest Stable Version](https://img.shields.io/packagist/v/bartlett/umlwriter.svg?style=flat-square)](https://packagist.org/packages/bartlett/umlwriter)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg?style=flat-square)](https://php.net/)

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

# Contributors

* Laurent Laville (Lead Developer)

[![](https://sourcerer.io/fame/llaville/llaville/umlwriter/images/0)](https://sourcerer.io/fame/llaville/llaville/umlwriter/links/0)
[![](https://sourcerer.io/fame/llaville/llaville/umlwriter/images/1)](https://sourcerer.io/fame/llaville/llaville/umlwriter/links/1)
[![](https://sourcerer.io/fame/llaville/llaville/umlwriter/images/2)](https://sourcerer.io/fame/llaville/llaville/umlwriter/links/2)
[![](https://sourcerer.io/fame/llaville/llaville/umlwriter/images/3)](https://sourcerer.io/fame/llaville/llaville/umlwriter/links/3)
[![](https://sourcerer.io/fame/llaville/llaville/umlwriter/images/4)](https://sourcerer.io/fame/llaville/llaville/umlwriter/links/4)
[![](https://sourcerer.io/fame/llaville/llaville/umlwriter/images/5)](https://sourcerer.io/fame/llaville/llaville/umlwriter/links/5)
[![](https://sourcerer.io/fame/llaville/llaville/umlwriter/images/6)](https://sourcerer.io/fame/llaville/llaville/umlwriter/links/6)
[![](https://sourcerer.io/fame/llaville/llaville/umlwriter/images/7)](https://sourcerer.io/fame/llaville/llaville/umlwriter/links/7)

## Credits

[bartlett/graph-uml](https://github.com/llaville/graph-uml) is a refactored version (with more features) of [clue/graph-uml](https://github.com/clue/graph-uml) project, licensed under MIT.

## License

This library is licensed under the BSD-3-clauses License - see the `LICENSE` file for details
