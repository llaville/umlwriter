<?php
/**
 * The UmlWriter diagram:render:namespace command.
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
 * Diagram statements generator for a single namespace
 */
class DiagramRenderNamespace extends DiagramRender
{
    protected function configure()
    {
        parent::configure();

        $this->setName('diagram:render:namespace')
            ->setDescription('Generate diagram statements of a single namespace')
            ->addArgument(
                'object',
                InputArgument::REQUIRED,
                'Class or Namespace'
            )
        ;
    }
}
