<?php
declare(strict_types=1);

namespace Bartlett\UmlWriter\Service;

use Bartlett\GraphUml\Generator\GeneratorInterface;
use Bartlett\GraphUml\ClassDiagramBuilder;

use Go\ParserReflection\ReflectionFile;
use Go\ParserReflection\ReflectionFileNamespace;

use Graphp\Graph\Graph;

use Symfony\Component\Finder\Finder;

class ClassDiagramRenderer
{
    /** @var Graph */
    private $graph;

    /** @var array  */
    private $metaData;

    public function __invoke(Finder $finder, GeneratorInterface $generator, array $parameters = []): string
    {
        $this->initGraph($parameters);

        $builder = new ClassDiagramBuilder(
            $generator,
            $this->graph,
            array_merge(['label_format' => 'html'], $parameters)
        );

        foreach ($finder as $file) {
            $filename = $file->getRealPath();
            $reflectionFile = new ReflectionFile($filename);

            // in case there are many namespaces in the same file (no PSR-4 compliant)
            foreach ($reflectionFile->getFileNamespaces() as $namespaceName => $namespace) {
                $reflectionFileNamespace = new ReflectionFileNamespace($filename, $namespaceName);
                $this->metaData['namespaces'][] = $namespaceName;

                foreach ($reflectionFileNamespace->getClasses() as $class) {
                    if ($class->isInterface()) {
                        $this->metaData['interfaces'][] = $class->getName();
                    } else {
                        $this->metaData['classes'][] = $class->getName();
                    }
                    $builder->createVertexClass($class);
                }
            }
        }

        return $generator->createScript($this->graph);
    }

    /**
     * Returns list of entities found in data source.
     *
     * @return array
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

    private function initGraph(array $parameters): void
    {
        $this->metaData = [
            'classes' => [],
            'interfaces' => [],
            'namespaces' => [],
        ];

        $this->graph = new Graph();

        $attributes = array_filter($parameters, function($key) {
            return (strpos($key, 'graph.') === 0
                || strpos($key, 'node.') === 0
                || strpos($key, 'edge.') === 0
                || strpos($key, 'cluster.') === 0
            );
        },ARRAY_FILTER_USE_KEY);

        $this->graph->setAttributes($attributes);
    }
}
