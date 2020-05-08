<?php
declare(strict_types=1);

namespace Bartlett\UmlWriter\Tests;

use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;
use Symfony\Component\Finder\Finder;

class PlantUMLIssueTest extends TestCase
{
    private const ISSUE_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'issues';
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
        $finder->in(self::ISSUE_DIR)->name('gh-7.php');

        $generatorFactory = new GeneratorFactory('plantuml');
        // creates instance of Bartlett\GraphPlantUml\PlantUmlGenerator
        $generator = $generatorFactory->getGenerator();

        $renderer = new ClassDiagramRenderer();
        $script = $renderer($finder, $generator);

        $this->assertStringEqualsFile(self::ISSUE_DIR . DIRECTORY_SEPARATOR . 'gh-7.puml', $script);
    }
}
