<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\UmlWriter\Generator;

use Bartlett\GraphUml\Generator\GeneratorInterface;

use function strtolower;

/**
 * @author Laurent Laville
 */
abstract class AbstractGeneratorFactory implements GeneratorFactoryInterface
{
    protected string $generator;

    final public function __construct(string $generator = '')
    {
        $this->generator = strtolower($generator);
    }

    public function createInstance(string $provider): GeneratorFactoryInterface
    {
        return new static($provider);
    }

    abstract public function getGenerator(): GeneratorInterface;
}