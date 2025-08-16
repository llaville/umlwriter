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

use Composer\InstalledVersions;

use PHPUnit\Framework\Attributes\Group;

use Symfony\Component\Finder\Finder;

use ReflectionException;

use function sprintf;

/**
 * @author Laurent Laville
 */
class PlantUMLIssueTest extends TestCase
{
    private const ISSUE_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'issues';

    /**
     * Regression test for bug GH#7
     *
     * @link https://github.com/llaville/umlwriter/issues/7
     *       "version 1.2.0 outputs invalid plantuml files "
     * @throws ReflectionException
     */
    #[Group('regression')]
    public function testBugGH7(): void
    {
        $package = 'bartlett/graph-plantuml-generator';
        if (!InstalledVersions::isInstalled($package)) {
            $this->markTestSkipped(sprintf('The "%s" package is not installed.', $package));
        }

        $finder = new Finder();
        $finder->in(self::ISSUE_DIR)->name('gh-7.php');

        $generatorFactory = new GeneratorFactory();
        // creates instance of Bartlett\GraphPlantUml\PlantUmlGenerator
        $generator = $generatorFactory->createInstance('plantuml');

        $renderer = new ClassDiagramRenderer();
        $graph = $renderer($finder, $generator);
        $script = $generator->createScript($graph);

        $this->assertStringEqualsFile(self::ISSUE_DIR . DIRECTORY_SEPARATOR . 'gh-7.puml', $script);
    }
}
