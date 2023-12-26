<!-- markdownlint-disable MD013 -->
# Creating a new Generator

You must follow these steps:

## **1.** creates your generator class

This class must follow the `GeneratorInterface` contract.

```php
<?php
namespace Name\Space;

use Bartlett\GraphUml\Formatter\FormatterInterface;
use Bartlett\GraphUml\Formatter\HtmlFormatter;
use Bartlett\GraphUml\Generator\AbstractGenerator;
use Bartlett\GraphUml\Generator\GeneratorInterface;

use Graphp\Graph\Graph;

class MyGenerator extends AbstractGenerator implements GeneratorInterface
{
    public function getFormatter(): FormatterInterface
    {
        return new HtmlFormatter($this->options);
    }

    public function getName(): string
    {
        return 'mygenerator';
    }

    public function createScript(Graph $graph): string
    {
        return 'TODO: Implement createScript() method.';
    }

    public function createImageFile(Graph $graph, string $cmdFormat): string
    {
        return '/image_generation_not_implemented';
    }
}
```

## **2.** creates your generator factory class

This factory should be able to load your new generator class.

```php
<?php
namespace Name\Space;

use Bartlett\GraphUml\Generator\GeneratorInterface;
use Bartlett\UmlWriter\Generator\GeneratorFactory;

class MyGeneratorFactory extends GeneratorFactory
{
    public function createInstance(string $provider, string $format = 'svg', string $executable = ''): GeneratorInterface
    {
        if ('mygenerator' === $provider) {
            return new MyGenerator($executable, $format);
        }
        // fallback to default GeneratorFactory behavior (checks for GraphViz or PlantUML)
        parent::createInstance($provider, $format, $executable);
    }
}
```

## **3.** autoloader

Of course your classes must be loadable with your autoloader.

```php
<?php
// bootstrap.php

use Composer\Autoload\ClassLoader;

return function (): void
{
    /** @var ClassLoader $loader */
    $loader = require dirname(__DIR__, 2) . '/vendor/autoload.php';
    $loader->addClassMap(
        [
            'Name\\Space\\MyGenerator' => __DIR__ . '/resources.php',
            'Name\\Space\\MyGeneratorFactory' => __DIR__ . '/resources.php',
        ]
    );
};
```

## **4.** on console command

Now if you want to use the `diagram:class` command, you'll need to modify the application launcher `bin/launcher`
to inject the new generator factory in service container.

```php
<?php
// app.php

$bootstrap = require __DIR__ . '/bootstrap.php';
$bootstrap();

use Bartlett\UmlWriter\Console\Application;
use Bartlett\UmlWriter\Service\ContainerService;
use Bartlett\UmlWriter\Generator\GeneratorFactoryInterface;
use Name\Space\MyGeneratorFactory;

$container = new ContainerService();
$container->set(GeneratorFactoryInterface::class, fn() => new MyGeneratorFactory());

$application = new Application($container);
$application->run();
```

You have then to invoke `bin/umlwriter diagram:class --generator=mygenerator` command to get results.

![MyGenerator Results](../assets/images/mygenerator-results.png)

## **5.** on batch mode

Alternative way is to use the batch PHP mode.

```php
<?php

use Bartlett\UmlWriter\Service\ClassDiagramRenderer;
use Name\Space\MyGeneratorFactory;
use Symfony\Component\Finder\Finder;

$bootstrap = require __DIR__ . '/bootstrap.php';
$bootstrap();

// path to directory where to find PHP source code
$dataSource = dirname(__DIR__, 2) . '/src';

$finder = new Finder();
$finder->in($dataSource)->name('*.php');

$generatorFactory = new MyGeneratorFactory();
// creates instance of Name\Space\MyGenerator
$generator = $generatorFactory->createInstance('mygenerator');

$renderer = new ClassDiagramRenderer();
// generates UML class diagram of all objects found in dataSource
$graph = $renderer($finder, $generator);

$script = $generator->createScript($graph);

echo $script, PHP_EOL;
```

That will only display
```text
TODO: Implement createScript() method.
```
