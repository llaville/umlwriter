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

    public function __invoke(Finder $finder, GeneratorInterface $generator): string
    {
        $this->initGraph($generator->getName());

        $builder = new ClassDiagramBuilder(
            $generator,
            $this->graph,
            ['label-format' => 'html']
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

    private function initGraph(string $generator): void
    {
        $this->metaData = [
            'classes' => [],
            'interfaces' => [],
            'namespaces' => [],
        ];

        $this->graph = new Graph();

        $attributes = [
            'graph' => [
                'name' => 'G',
                'overlap' => 'false',
            ],
            'node' => [
                'fontname' => "Verdana",
                'fontsize' => 8,
                'shape' => "none",
                'margin' => 0,
                'fillcolor' => '#FEFECE',
                'style' => 'filled',
            ],
            'edge' => [
                'fontname' => "Verdana",
                'fontsize' => 8,
            ]
        ];
        foreach ($attributes as $usedBy => $values) {
            foreach ($values as $name => $value) {
                $this->graph->setAttribute($generator . '.' . $usedBy . '.' . $name, $value);
            }
        }
    }
}
