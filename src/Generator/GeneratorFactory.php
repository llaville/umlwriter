<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\UmlWriter\Generator;

use Bartlett\GraphPlantUml\PlantUmlGenerator;
use Bartlett\GraphUml\Generator\GeneratorInterface;
use Bartlett\GraphUml\Generator\GraphVizGenerator;

use Graphp\GraphViz\GraphViz;

use RuntimeException;

/**
 * @author Laurent Laville
 */
class GeneratorFactory extends AbstractGeneratorFactory
{
    public function getGenerator(): GeneratorInterface
    {
        if ('graphviz' === $this->generator) {
            return new GraphVizGenerator(new GraphViz());
        }
        if ('plantuml' === $this->generator) {
            return new PlantUmlGenerator();
        }

        throw new RuntimeException(
            sprintf('Generator "%s" is unknown', $this->generator)
        );
    }
}
