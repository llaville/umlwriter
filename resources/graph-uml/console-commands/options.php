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

return [
    'show_private' => false,
    'show_protected' => false,
    // @link https://graphviz.gitlab.io/docs/attrs/rankdir/
    'graph.rankdir' => 'TB',
    // @link https://graphviz.gitlab.io/docs/attrs/bgcolor/
    'graph.bgcolor' => 'transparent',
    // @link https://graphviz.gitlab.io/docs/attrs/fillcolor/
    'node.fillcolor' => '#FEFECE',
    // @link https://graphviz.gitlab.io/docs/attrs/style/
    'node.style' => 'filled',
    // @link https://plantuml.com/en/color
    'cluster.Bartlett\\UmlWriter\\Console.graph.bgcolor' => 'BurlyWood',
    'cluster.Bartlett\\UmlWriter\\Console\\Command.graph.bgcolor' => 'BurlyWood',
];
