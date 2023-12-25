<!-- markdownlint-disable MD013 -->
# Generators

GraPHP UML used at least two components :

- the mathematical graph/network [GraPHP](https://github.com/graphp/graph) library to draw UML diagrams.
- any generator that implement the following contract.
GraPHP UML uses [GraphVizGenerator](https://github.com/llaville/graph-uml/blob/master/src/Generator/GraphVizGenerator.php)
as default, but allow others that may be registered later at runtime.
UmlWrite includes as alternative the [GraPHP PlantUML Generator](https://github.com/llaville/graph-plantuml-generator)

## Contract

Each generator used to build graph statements should implement following interface.

```php
<?php
namespace Bartlett\GraphUml\Generator;

use Bartlett\GraphUml\Formatter\FormatterInterface;

use Graphp\Graph\Graph;

use ReflectionClass;
use ReflectionExtension;

interface GeneratorInterface
{
    public function setOptions(array $values): void;

    public function getFormatter(): FormatterInterface;

    public function getName(): string;

    public function getPrefix(): string;

    public function getLabelClass(ReflectionClass $reflection): string;

    public function getLabelExtension(ReflectionExtension $reflection): string;

    public function createScript(Graph $graph): string;

    public function createImageFile(Graph $graph, string $cmdFormat): string;
}
```

- `setOptions()` declares all options used to personalize generator's formatters.

- `getFormatter()` is in charge to retrieve instance of a formatter that will produce vertex labels.

- `getName()` identifies the generator with a unique name.

- `getPrefix()` prefixes all public attributes (graph, node, edge, cluster) only if necessary.

- `getLabelClass()` is in charge to make the label of the vertex corresponding to a class or interface element.

- `getLabelExtension()` is in charge to make the label of the vertex corresponding to an extension element.

- `createScript()` is in charge to build graph statements depends on generator used.

- `createImageFile()` is in charge to draw image graph in format asked (see `setFormat()`).

## Common functions

An [AbstractGenerator](https://github.com/llaville/graph-uml/blob/master/src/Generator/AbstractGenerator.php) class
allow to implement basic image creation behaviors common to all generators.
