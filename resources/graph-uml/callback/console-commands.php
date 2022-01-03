<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @since Release 3.0.0
 * @author Laurent Laville
 */


use Bartlett\GraphUml\Filter\NamespaceFilterInterface;
use Bartlett\GraphUml\Generator\GeneratorInterface;

use Graphp\Graph\Graph;

$callback = function (Generator $vertices, GeneratorInterface $generator, Graph $graph, array $options) {
    foreach ($vertices as $fqcn) {
        $this->createVertexClass($fqcn);

        $namespaceFilter = $options['namespace_filter'];

        if ($namespaceFilter instanceof NamespaceFilterInterface) {
            $cluster = $namespaceFilter->filter($fqcn);

            $attributes = ['bgcolor' => 'White'];

            foreach ($attributes as $attr => $value) {
                $attribute = sprintf('cluster.%s.graph.%s', $cluster, $attr);
                $graph->setAttribute($generator->getPrefix() . $attribute, $value);
            }
        }
    }
};
