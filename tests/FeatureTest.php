<?php declare(strict_types=1);

namespace Bartlett\UmlWriter\Tests;

use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;
use Bartlett\GraphUml\Generator\GeneratorInterface;
use Bartlett\UmlWriter\Service\ConfigurationHandler;

use Symfony\Component\Finder\Finder;

use Generator;
use ReflectionException;

class FeatureTest extends TestCase
{
    private const FIXTURE_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures';

    private function provider(string $name): Generator
    {
        $generatorFactory = new GeneratorFactory($name);
        // creates either instance of:
        // - Bartlett\GraphUml\GraphVizGenerator
        // - Bartlett\GraphPlantUml\PlantUmlGenerator
        $generator = $generatorFactory->getGenerator();

        $fixtures = new Finder();
        $fixtures->in(self::FIXTURE_DIR)->name('*.php')->sortByName();

        foreach ($fixtures as $file) {
            $fixture = $file->getRelativePathname();
            $finder = new Finder();
            $finder->in(self::FIXTURE_DIR)->name($fixture);
            yield $fixture => [$fixture, $finder, $generator];
        }
    }

    /**
     * Data Provider to test generation of graph statements with Graphviz generator
     */
    public function graphvizProvider(): Generator
    {
        return $this->provider('graphviz');
    }

    /**
     * Data Provider to test generation of graph statements with PlantUML generator
     */
    public function plantumlProvider(): Generator
    {
        return $this->provider('plantuml');
    }

    /**
     * Tests graph statements generation with the Graphviz generator
     *
     * @dataProvider graphvizProvider
     * @throws ReflectionException
     */
    public function testGraphvizGenerator(string $fixture, Finder $finder, GeneratorInterface $generator): void
    {
        $configHandler = new ConfigurationHandler(null);
        $parameters = $configHandler->toFlat();
        $renderer = new ClassDiagramRenderer();
        $script = $renderer($finder, $generator, $parameters);

        $this->assertStringEqualsFile(
            self::FIXTURE_DIR . DIRECTORY_SEPARATOR . basename($fixture, '.php') . '.gv',
            $script,
            'Failed asserting that two graphs statements are equal.'
        );
    }

    /**
     * Tests graph statements generation with the PlantUML generator
     *
     * @dataProvider plantumlProvider
     * @throws ReflectionException
     */
    public function testPlantumlGenerator(string $fixture, Finder $finder, GeneratorInterface $generator): void
    {
        $configHandler = new ConfigurationHandler(null);
        $parameters = $configHandler->toFlat();
        $renderer = new ClassDiagramRenderer();
        $script = $renderer($finder, $generator, $parameters);

        $this->assertStringEqualsFile(
            self::FIXTURE_DIR . DIRECTORY_SEPARATOR . basename($fixture, '.php') . '.puml',
            $script,
            'Failed asserting that two graphs statements are equal.'
        );
    }
}
