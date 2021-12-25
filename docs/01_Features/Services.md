<!-- markdownlint-disable MD013 -->
# Services

UmlWriter 2.0 contains two different services.

* **ContainerService** implements a [PSR-11](https://www.php-fig.org/psr/psr-11/) compatible service container
that allows you to standardize and centralize the way objects are constructed.

* **ClassDiagramRenderer** that is in charge to add vertices and edges in the graph
corresponding to data source(s) parsed.

## Service Container

We distinguish two kind of services:

* **internal** like `ClassDiagramRenderer` and `ClassDiagramCommand` that cannot be changed at runtime.
* **runtime** like `InputInterface`, `OutputInterface` and `GeneratorFactoryInterface` (the others) that could be changed.

## Class Diagram Renderer

* Is in charge to add vertices and edge with the `__invoke()` method.

* `getGraph()` method allows retrieving current graph to let you ability to personalize render by setting graph, node or edge attributes.

* Is able to retrieve all namespaces, classes, interfaces found during parse data source with `getMetadata()` method.

```php
<?php
// Example

use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;
use Symfony\Component\Finder\Finder;

// path to directory where to find PHP source code
$dataSource = 'src';

$finder = new Finder();
$finder->in($dataSource)->name('*.php');

$generatorFactory = new GeneratorFactory('graphviz');
// creates instance of Bartlett\GraphUml\Generator\GraphVizGenerator
$generator = $generatorFactory->getGenerator();

$renderer = new ClassDiagramRenderer();
// generates UML class diagram of all objects found in dataSource (in graphviz format)
$script = $renderer($finder, $generator);
// show all metadata
var_dump($renderer->getMetadata());
```

That could produce such results (with UmlWriter src directory)

```text
array(3) {
  ["classes"]=>
  array(8) {
    [0]=>
    string(53) "Bartlett\UmlWriter\Generator\AbstractGeneratorFactory"
    [1]=>
    string(45) "Bartlett\UmlWriter\Generator\GeneratorFactory"
    [2]=>
    string(47) "Bartlett\UmlWriter\Service\ConfigurationHandler"
    [3]=>
    string(47) "Bartlett\UmlWriter\Service\ClassDiagramRenderer"
    [4]=>
    string(43) "Bartlett\UmlWriter\Service\ContainerService"
    [5]=>
    string(38) "Bartlett\UmlWriter\Console\Application"
    [6]=>
    string(54) "Bartlett\UmlWriter\Console\Command\ClassDiagramCommand"
    [7]=>
    string(47) "Bartlett\UmlWriter\Config\Loader\YamlFileLoader"
  }
  ["interfaces"]=>
  array(1) {
    [0]=>
    string(54) "Bartlett\UmlWriter\Generator\GeneratorFactoryInterface"
  }
  ["namespaces"]=>
  array(5) {
    [0]=>
    string(28) "Bartlett\UmlWriter\Generator"
    [3]=>
    string(26) "Bartlett\UmlWriter\Service"
    [6]=>
    string(26) "Bartlett\UmlWriter\Console"
    [7]=>
    string(34) "Bartlett\UmlWriter\Console\Command"
    [8]=>
    string(32) "Bartlett\UmlWriter\Config\Loader"
  }
}
```

## Architecture

![Service](./services.graphviz.svg)
