<?php
/**
 * Reflector (reverse engine) interface
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

/**
 * Reflector (reverse engine) interface
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  Release: @package_version@
 * @link     http://php5.laurent-laville.org/umlwriter/
 * @since    Class available since Release 1.0.0-RC1
 */
interface ReflectorInterface
{
    /**
     * Returns a reflection class of the given object (FQN expected).
     *
     * @param string $className Class name

     * @return ReflectionClass
     */
    public function getClass($className);

    /**
     * Returns all objects from all namespaces.
     *
     * @return array
     */
    public function getClasses();

    /**
     * Returns a list of reflection class, of the given namespace.
     *
     * @param string $namespaceName Namespace name
     *
     * @return ReflectionClass[]
     */
    public function getNamespace($namespaceName);
}
