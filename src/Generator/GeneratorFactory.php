<?php
declare(strict_types=1);

namespace Bartlett\UmlWriter\Generator;

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

        throw new RuntimeException(
            sprintf('Generator "%s" is unknown', $this->generator)
        );
    }
}
