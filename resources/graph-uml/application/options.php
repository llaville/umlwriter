<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Laurent Laville
 * @since Release 4.0.0
 */

return [
    'show_private' => false,
    'show_protected' => false,
    // @link https://graphviz.gitlab.io/docs/attrs/rankdir/
    'graph.rankdir' => 'LR',
    // @link https://plantuml.com/en/color
    'clusters.graph.bgcolor' => 'white',
    'cluster.Symfony\\Component\\Console.graph.bgcolor' => 'LightSkyBlue',
    'cluster.Symfony\\Component\\Console\\Command.graph.bgcolor' => 'LightSkyBlue',
    'cluster.Symfony\\Component\\Config\\Loader.graph.bgcolor' => 'LightSkyBlue',
    'cluster.Symfony\\Contracts\\Service.graph.bgcolor' => 'LightSkyBlue',
    'cluster.Bartlett\\UmlWriter\\Service.graph.bgcolor' => 'BurlyWood',
    'cluster.Bartlett\\UmlWriter\\Console.graph.bgcolor' => 'BurlyWood',
    'cluster.Bartlett\\UmlWriter\\Console\\Command.graph.bgcolor' => 'BurlyWood',
    'cluster.Bartlett\\UmlWriter\\Config\\Loader.graph.bgcolor' => 'BurlyWood',
    'cluster.Bartlett\\UmlWriter\\Generator.graph.bgcolor' => 'BurlyWood',
];
