<?php
declare(strict_types=1);

namespace Bartlett\UmlWriter\Generator;

use Bartlett\GraphUml\Generator\GeneratorInterface;

abstract class AbstractGeneratorFactory implements GeneratorFactoryInterface
{
    protected $generator;

    public function __construct(string $generator = '')
    {
        $this->generator = strtolower($generator);
    }

    public function createInstance(string $generator): GeneratorFactoryInterface
    {
        return new static($generator);
    }

    abstract public function getGenerator(): GeneratorInterface;
}
