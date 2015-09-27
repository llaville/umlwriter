<?php
/**
 * PHP_Reflect (reverse engine)
 *
 * PHP version 5
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  GIT: $Id$
 * @link     http://php5.laurent-laville.org/umlwriter/
 */

namespace Bartlett\UmlWriter\Reflector;

use Bartlett\Reflect\Client;
use Bartlett\Reflect\Model\ClassModel;

/**
 * PHP_Reflect (reverse engine)
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  Release: @package_version@
 * @link     http://php5.laurent-laville.org/umlwriter/
 * @since    Class available since Release 1.0.0-RC1
 */
class Reflect implements ReflectorInterface
{
    private $models;

    /**
     * Creates a new instance of Bartlett\Reflect engine
     *
     * @param string $dataSource Path to directory where to find PHP source code
     */
    public function __construct($dataSource)
    {
        // creates an instance of client
        $client = new Client();

        // request for a Bartlett\Reflect\Api\Analyser
        $api = $client->api('analyser');

        // perform request, on data source
        $metrics = $api->run($dataSource, array('reflection'), null, false, false);

        $this->models = $metrics['Bartlett\Reflect\Analyser\ReflectionAnalyser'];
    }

    /**
     * {@inheritdoc}
     */
    public function getClass($className)
    {
        $collect = $this->models->filter(
            function ($element) use ($className) {
                return $element instanceof ClassModel
                    && $element->getName() === $className;
            }
        );

        if (count($collect) === 0) {
            throw new \Exception(
                sprintf('Class "%s" not found.', $className)
            );
        }
        return $collect->first();
    }

    /**
     * {@inheritdoc}
     */
    public function getClasses()
    {
        $collect = $this->models->filter(
            function ($element) {
                return $element instanceof ClassModel;
            }
        );
        return $collect;
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace($namespaceName)
    {
        $collect = $this->models->filter(
            function ($element) use ($namespaceName) {
                $accept = ($element->getNamespaceName() === $namespaceName)
                    && ($element instanceof ClassModel);
                return $accept;
            }
        );

        if (count($collect) === 0) {
            throw new \Exception(
                sprintf('Namespace "%s" not found.', $namespaceName)
            );
        }
        return $collect;
    }
}
