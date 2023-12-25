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

use LogicException;
use function sprintf;
use function strtolower;

/**
 * @author Laurent Laville
 */
class GeneratorFactory implements GeneratorFactoryInterface
{
    public function createInstance(string $provider, string $format = 'svg', ?string $executable = null): GeneratorInterface
    {
        return match (strtolower($provider)) {
            'graphviz' => new GraphVizGenerator(new GraphViz(), 'dot', $format),
            'plantuml' => new PlantUmlGenerator('vendor/bin/plantuml', $format),
            default => throw new LogicException(sprintf('Provider "%s" is not supported', $provider))
        };
    }
}
