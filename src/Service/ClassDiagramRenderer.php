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

use Graphp\Graph\Graph;

use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflector\DefaultReflector;
use Roave\BetterReflection\SourceLocator\Type\SingleFileSourceLocator;

use Symfony\Component\Finder\Finder;

use ReflectionException;
use function array_merge;

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
    public function __invoke(Finder $finder, GeneratorInterface $generator, array $parameters = []): string
    {
        $this->initGraph($parameters);

        $builder = new ClassDiagramBuilder(
            $generator,
            $this->graph,
            array_merge(['label_format' => 'html'], $parameters)
        );

        $astLocator = (new BetterReflection())->astLocator();

        foreach ($finder as $file) {
            $filename = $file->getRealPath();
            $reflector = new DefaultReflector(new SingleFileSourceLocator($filename, $astLocator));

            foreach ($reflector->reflectAllClasses() as $class) {
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

        return $generator->createScript($this->graph);
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

    public function getGraph(): Graph
    {
        return $this->graph;
    }

    /**
     * @param array<string, mixed> $parameters
     */
    private function initGraph(array $parameters): void
    {
        $this->metaData = [
            'classes' => [],
            'interfaces' => [],
            'namespaces' => [],
        ];

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
