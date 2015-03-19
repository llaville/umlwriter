<?php
/**
 * TokenReflection (reverse engine)
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

use TokenReflection\Broker;

/**
 * TokenReflection (reverse engine)
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  Release: @package_version@
 * @link     http://php5.laurent-laville.org/umlwriter/
 * @since    Class available since Release 1.0.0-RC1
 */
class TokenReflection implements ReflectorInterface
{
    private $broker;

    /**
     * Creates a new instance of Andrewsville\TokenReflection engine
     *
     * @param string $dataSource Path to directory where to find PHP source code
     */
    public function __construct($dataSource)
    {
        $this->broker = new Broker(new Broker\Backend\Memory());
        $this->broker->process($dataSource);
    }

    /**
     * {@inheritdoc}
     */
    public function getClass($className)
    {
        return $this->broker->getClass($className);
    }

    /**
     * {@inheritdoc}
     */
    public function getClasses()
    {
        return $this->broker->getClasses();
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace($namespaceName)
    {
        $classes = $this->broker->getNamespace($namespaceName)->getClasses();
        return array_values($classes);
    }
}
