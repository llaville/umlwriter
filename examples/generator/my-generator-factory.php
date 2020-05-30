<?php

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
