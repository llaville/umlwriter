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
use Bartlett\GraphUml\Generator\GraphVizGenerator;

use Composer\InstalledVersions;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

use Symfony\Component\Finder\Finder;

use function sprintf;

/**
 * @author Laurent Laville
 * @since Release 4.4.0
 */
class GraphVizIssueTest extends TestCase
{
    private const ISSUE_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'issues';

    /**
     * Regression test for bug GH#32
     *
     * @link https://github.com/llaville/umlwriter/issues/32
     *       "Allow to print Graph statements even if GraphViz (dot) is not installed"
     */
    #[Group('regression')]
    #[DataProvider('dpDotExecutable')]
    public function testBugGH32(string $executable, bool $expectedException): void
    {
        $package = 'bartlett/graph-uml';
        if (!InstalledVersions::isInstalled($package)) {
            $this->markTestSkipped(sprintf('The "%s" package is not installed.', $package));
        }

        if ($expectedException) {
            $this->expectExceptionMessage('Unable to invoke "dot" to create image file');
        }

        $finder = new Finder();
        $finder->in(self::ISSUE_DIR)->name('when-dot-not-installed.php');

        $generatorFactory = new GeneratorFactory();
        // creates instance of Bartlett\GraphUml\Generator\GraphVizGenerator
        $generator = $generatorFactory->createInstance('graphviz');

        $renderer = new ClassDiagramRenderer();
        $graph = $renderer($finder, $generator);
        $command = $generator->createImageFile($graph);

        if (!$expectedException) {
            $this->assertIsString($command);
        }
    }

    public static function dpDotExecutable(): array
    {
        $executable = 'dot';
        $output = null;
        $resultCode = null;

        @exec('which ' . $executable, $output, $resultCode);

        $expectedException = $resultCode !== 0;

        return [
            [$executable, $expectedException],
        ];
    }
}
