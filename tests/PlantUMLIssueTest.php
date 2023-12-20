<?php declare(strict_types=1);

namespace Bartlett\UmlWriter\Tests;

use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;

use Symfony\Component\Finder\Finder;

use ReflectionException;

class PlantUMLIssueTest extends TestCase
{
    private const ISSUE_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'issues';

    /**
     * Regression test for bug GH#7
     *
     * @link https://github.com/llaville/umlwriter/issues/7
     *       "version 1.2.0 outputs invalid plantuml files "
     * @group regression
     * @throws ReflectionException
     */
    public function testBugGH7(): void
    {
        $finder = new Finder();
        $finder->in(self::ISSUE_DIR)->name('gh-7.php');

        $generatorFactory = new GeneratorFactory('plantuml');
        // creates instance of Bartlett\GraphPlantUml\PlantUmlGenerator
        $generator = $generatorFactory->getGenerator();

        $renderer = new ClassDiagramRenderer();
        $graph = $renderer($finder, $generator);
        $script = $generator->createScript($graph);

        $this->assertStringEqualsFile(self::ISSUE_DIR . DIRECTORY_SEPARATOR . 'gh-7.puml', $script);
    }
}
