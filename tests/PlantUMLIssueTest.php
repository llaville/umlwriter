<?php
declare(strict_types=1);

namespace Bartlett\UmlWriter\Tests;

use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;
use Symfony\Component\Finder\Finder;

class PlantUMLIssueTest extends TestCase
{
    /**
     * Regression test for bug GH#7
     *
     * @link https://github.com/llaville/umlwriter/issues/7
     *       "version 1.2.0 outputs invalid plantuml files "
     * @group regression
     * @return void
     */
    public function testBugGH7()
    {
        $finder = new Finder();
        $finder->in(__DIR__ . '/issues')->name('gh-7.php');

        $generatorFactory = new GeneratorFactory('plantuml');
        // creates instance of Bartlett\GraphPlantUml\PlantUmlGenerator
        $generator = $generatorFactory->getGenerator();

        $renderer = new ClassDiagramRenderer();
        $script = $renderer($finder, $generator);

        $this->assertStringEqualsFile(__DIR__ . '/issues/gh-7.puml', $script);
    }
}
