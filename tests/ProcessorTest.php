<?php
/**
 * Unit tests for PHP_CompatInfo package, issues reported
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    UmlWriter
 * @subpackage Tests
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    GIT: $Id$
 * @link       http://php5.laurent-laville.org/umlwriter/
 * @since      Class available since Release 1.0.0-RC2
 */

namespace Bartlett\Tests\UmlWriter;

/**
 * Tests for PHP_CompatInfo, retrieving reference elements,
 * and versioning information.
 *
 * @category   PHP
 * @package    UmlWriter
 * @subpackage Tests
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://php5.laurent-laville.org/umlwriter/
 */
class ProcessorTest extends \PHPUnit_Framework_TestCase
{
    private function generator($extFile)
    {
        $fixtures = __DIR__ . DIRECTORY_SEPARATOR
            . 'fixtures' . DIRECTORY_SEPARATOR;

        $graphs   = array();
        $iterator = new \DirectoryIterator($fixtures);

        foreach ($iterator as $file) {
            /* @var $file \SplFileInfo */
            if (!preg_match('/\.php$/', $file)) {
                continue;
            }

            $phpFile = $file->getRealpath();
            $gFile   = preg_replace('/\.php$/', $extFile, $file->getRealPath());

            if (!file_exists($gFile)) {
                continue;
            }
            $gCode = file_get_contents($gFile);

            $graphs[] = array(
                'phpFile'    => $phpFile,
                'graphStmts' => $gCode,
            );
        }

        asort($graphs);
        return $graphs;
    }

    /**
     * Data Provider to test generation of graph statements with Graphviz processor
     *
     * @return array
     */
    public function graphvizProvider()
    {
        return $this->generator('.gv');
    }

    /**
     * Data Provider to test generation of graph statements with PlantUML processor
     *
     * @return array
     */
    public function plantumlProvider()
    {
        return $this->generator('.puml');
    }

    /**
     * Tests graph statements generation with the Graphviz processor
     *
     * @return void
     * @dataProvider graphvizProvider
     */
    public function testGraphvizProcessor($phpFile, $graphStmts)
    {
        // uses Bartlett\Reflect as reverse engine
        $reflector = new \Bartlett\UmlWriter\Reflector\Reflect($phpFile);

        // creates a new instance of Graphviz processor
        $processor = new \Bartlett\UmlWriter\Processor\GraphvizProcessor($reflector);

        // render a full graph with all objects
        $gvStmts = $processor->setGraphId('G1')->render();

        $this->assertEquals($graphStmts, $gvStmts);
    }

    /**
     * Tests graph statements generation with the PlantUML processor
     *
     * @return void
     * @dataProvider plantumlProvider
     */
    public function testPlantUMLProcessor($phpFile, $graphStmts)
    {
        // uses Bartlett\Reflect as reverse engine
        $reflector = new \Bartlett\UmlWriter\Reflector\Reflect($phpFile);

        // creates a new instance of PlantUML processor
        $processor = new \Bartlett\UmlWriter\Processor\PlantUMLProcessor($reflector);

        // render a full graph with all objects
        $pumlStmts = $processor->render();

        $this->assertEquals($graphStmts, $pumlStmts);
    }
}
