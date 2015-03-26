<?php
/**
 * The UmlWriter diagram:render:class command.
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

namespace Bartlett\UmlWriter\Console\Command;

use Symfony\Component\Console\Input\InputArgument;

/**
 * Diagram statements generator for a single class
 */
class DiagramRenderClass extends DiagramRender
{
    protected function configure()
    {
        parent::configure();
        
        $this->setName('diagram:render:class')
            ->setDescription('Generate diagram statements of a single class')
            ->addArgument(
                'object',
                InputArgument::REQUIRED,
                'Class or Namespace'
            )
        ;
    }
}
