<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Laurent Laville
 */

namespace Name\Space;

use Bartlett\GraphUml\Generator\GeneratorInterface;
use Bartlett\UmlWriter\Generator\GeneratorFactory;

class MyGeneratorFactory extends GeneratorFactory
{
    public function getGenerator(): GeneratorInterface
    {
        if ('mygenerator' === $this->generator) {
            return new MyGenerator();
        }

        // fallback to default GeneratorFactory behavior (checks for GraphViz or PlantUML)
        return parent::getGenerator();
    }
}
