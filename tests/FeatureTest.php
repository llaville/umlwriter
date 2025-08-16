<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bartlett\UmlWriter\Tests;

use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;
use Bartlett\GraphUml\Generator\GeneratorInterface;
use Bartlett\UmlWriter\Service\ConfigurationHandler;

use Composer\InstalledVersions;

use PHPUnit\Framework\Attributes\DataProvider;

use Symfony\Component\Finder\Finder;

use Generator;
use LogicException;
use ReflectionException;
use function sprintf;

/**
 * @author Laurent Laville
 */
class FeatureTest extends TestCase
{
    private const FIXTURE_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures';

    private static function provider(string $name): Generator
    {
        $package = match ($name) {
            'graphviz' => 'bartlett/graph-uml',
            'plantuml' => 'bartlett/graph-plantuml-generator',
            default => throw new LogicException(sprintf('Provider "%s" is not implemented by Tests', $name))
        };

        if (InstalledVersions::isInstalled($package)) {
            $generatorFactory = new GeneratorFactory();
            // creates either instance of:
            // - Bartlett\GraphUml\GraphVizGenerator
            // - Bartlett\GraphPlantUml\PlantUmlGenerator
            $generator = $generatorFactory->createInstance($name);
        } else {
            $generator = null;
        }

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
    public static function graphvizProvider(): Generator
    {
        return self::provider('graphviz');
    }

    /**
     * Data Provider to test generation of graph statements with PlantUML generator
     */
    public static function plantumlProvider(): Generator
    {
        return self::provider('plantuml');
    }

    /**
     * Tests graph statements generation with the Graphviz generator
     *
     * @throws ReflectionException
     */
    #[DataProvider('graphvizProvider')]
    public function testGraphvizGenerator(string $fixture, Finder $finder, ?GeneratorInterface $generator): void
    {
        if (null === $generator) {
            $provider = 'graphviz';
            $this->markTestSkipped(sprintf('Provider "%s" is not supported. Additional dependencies need to be installed.', $provider));
        }

        $configHandler = new ConfigurationHandler(null);
        $parameters = $configHandler->toFlat();
        $renderer = new ClassDiagramRenderer();
        $graph = $renderer($finder, $generator, $parameters);
        $script = $generator->createScript($graph);

        $this->assertStringEqualsFile(
            self::FIXTURE_DIR . DIRECTORY_SEPARATOR . basename($fixture, '.php') . '.gv',
            $script,
            'Failed asserting that two graphs statements are equal.'
        );
    }

    /**
     * Tests graph statements generation with the PlantUML generator
     *
     * @throws ReflectionException
     */
    #[DataProvider('plantumlProvider')]
    public function testPlantumlGenerator(string $fixture, Finder $finder, ?GeneratorInterface $generator): void
    {
        if (null === $generator) {
            $provider = 'plantuml';
            $this->markTestSkipped(sprintf('Provider "%s" is not supported. Additional dependencies need to be installed.', $provider));
        }

        $configHandler = new ConfigurationHandler(null);
        $parameters = $configHandler->toFlat();
        $renderer = new ClassDiagramRenderer();
        $graph = $renderer($finder, $generator, $parameters);
        $script = $generator->createScript($graph);

        $this->assertStringEqualsFile(
            self::FIXTURE_DIR . DIRECTORY_SEPARATOR . basename($fixture, '.php') . '.puml',
            $script,
            'Failed asserting that two graphs statements are equal.'
        );
    }
}
