<?php
declare(strict_types=1);

namespace Bartlett\UmlWriter\Generator;

use Bartlett\GraphPlantUml\PlantUmlGenerator;
use Bartlett\GraphUml\Generator\GeneratorInterface;
use Bartlett\GraphUml\Generator\GraphVizGenerator;

use Graphp\GraphViz\GraphViz;

use RuntimeException;

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
