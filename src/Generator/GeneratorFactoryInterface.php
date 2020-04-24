<?php
declare(strict_types=1);

namespace Bartlett\UmlWriter\Generator;

use Bartlett\GraphUml\Generator\GeneratorInterface;

interface GeneratorFactoryInterface
{
    public function createInstance(string $provider): GeneratorFactoryInterface;

    public function getGenerator(): GeneratorInterface;
}
