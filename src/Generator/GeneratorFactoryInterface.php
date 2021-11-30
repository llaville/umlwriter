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
interface GeneratorFactoryInterface
{
    public function createInstance(string $provider): GeneratorFactoryInterface;

    public function getGenerator(): GeneratorInterface;
}
