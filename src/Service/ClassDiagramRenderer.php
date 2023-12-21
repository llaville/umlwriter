<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\UmlWriter\Service;

use Bartlett\GraphUml\Generator\GeneratorInterface;
use Bartlett\GraphUml\ClassDiagramBuilder;

use Generator;
use Graphp\Graph\Graph;

use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflector\DefaultReflector;
use Roave\BetterReflection\SourceLocator\Type\AutoloadSourceLocator;
use Roave\BetterReflection\SourceLocator\Type\SingleFileSourceLocator;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

use ReflectionException;
use function array_filter;
use function array_merge;
use function array_unique;
use function is_string;
use function strpos;

/**
 * @author Laurent Laville
 */
final class ClassDiagramRenderer
{
    private Graph $graph;
    /** @var array<string, mixed>  */
    private array $metaData;

    /**
     * @param array<string, mixed> $parameters
     * @throws ReflectionException
     */
    public function __invoke(Finder|Generator $datasource, GeneratorInterface $generator, array $parameters = []): Graph
    {
        $this->metaData = [
            'classes' => [],
            'interfaces' => [],
            'namespaces' => [],
        ];

        $defaults = (new ConfigurationHandler())->toFlat();
        $options = array_merge($defaults, $parameters);
        $this->initGraph($options);

        $builder = new ClassDiagramBuilder($generator, $this->graph, $options);

        $astLocator = (new BetterReflection())->astLocator();

        foreach ($datasource as $source) {
            $classes = [];
            if ($source instanceof SplFileInfo) {
                $filename = $source->getRealPath();
                $reflector = new DefaultReflector(new SingleFileSourceLocator($filename, $astLocator));
                $classes = $reflector->reflectAllClasses();
            } elseif (is_string($source)) {
                $reflector = new DefaultReflector(new AutoloadSourceLocator($astLocator));
                $classes = [$reflector->reflectClass($source)];
            }

            foreach ($classes as $class) {
                if ($class->isAnonymous()) {
                    continue;
                }
                if ($class->isInterface()) {
                    $this->metaData['interfaces'][] = $class->getName();
                } else {
                    $this->metaData['classes'][] = $class->getName();
                }
                $builder->createVertexClass($class->getName());
            }
        }

        return $this->graph;
    }

    /**
     * Returns list of entities found in data source.
     *
     * @return array<string, mixed>
     */
    public function getMetadata(): array
    {
        $this->metaData['namespaces'] = array_unique($this->metaData['namespaces']);
        return $this->metaData;
    }

    /**
     * @param array<string, mixed> $parameters
     */
    private function initGraph(array $parameters): void
    {
        $this->graph = new Graph();

        $attributes = array_filter($parameters, function ($key) {
            return (strpos($key, 'graph.') === 0
                || strpos($key, 'node.') === 0
                || strpos($key, 'edge.') === 0
                || strpos($key, 'cluster.') === 0
            );
        }, ARRAY_FILTER_USE_KEY);

        $this->graph->setAttributes($attributes);
    }
}
