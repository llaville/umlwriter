<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\UmlWriter\Generator;

use Bartlett\GraphUml\Generator\GeneratorInterface;

/**
 * @author Laurent Laville
 */
abstract class AbstractGeneratorFactory implements GeneratorFactoryInterface
{
    /**
     * @var string
     */
    protected $generator;

    final public function __construct(string $generator = '')
    {
        $this->generator = strtolower($generator);
    }

    public function createInstance(string $generator): GeneratorFactoryInterface
    {
        return new static($generator);
    }

    abstract public function getGenerator(): GeneratorInterface;
}
