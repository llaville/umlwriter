<?php
/**
 * Diagram processor interface
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

namespace Bartlett\UmlWriter\Processor;

use Bartlett\UmlWriter\Reflector;

/**
 * Diagram processor interface
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  Release: @package_version@
 * @link     http://php5.laurent-laville.org/umlwriter/
 * @since    Class available since Release 1.0.0-RC1
 */
interface ProcessorInterface
{
    const GLOBAL_NAMESPACE = '+global';

    /**
     * Renders a class object
     *
     * @param string $className Class name
     *
     * @return string
     */
    public function renderClass($className);

    /**
     * Renders a namespace with all objects
     *
     * @param string $namespaceName Namespace name
     *
     * @return string
     */
    public function renderNamespace($namespaceName);

    /**
     * Renders a class, a namespace or the a full package
     *
     * @return string
     */
    public function render();
}
