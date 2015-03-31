<?php
/**
 * Graphviz diagram processor
 *
 * PHP version 5
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  GIT: $Id$
 * @link     http://php5.laurent-laville.org/umlwriter/
 * @link     http://plantuml.sourceforge.net/
 */

namespace Bartlett\UmlWriter\Processor;

/**
 * Diagram processor for Graphviz engine (http://graphviz.org/)
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  Release: @package_version@
 * @link     http://php5.laurent-laville.org/umlwriter/
 * @since    Class available since Release 1.0.0-RC1
 */
class GraphvizProcessor extends AbstractProcessor implements ProcessorInterface
{
    protected $namespaceSeparator = '\\';

    /**
     * Prints all objects (class, interface, trait)
     *
     * @return string
     */
    protected function renderObjects()
    {
        static $cluster = 0;

        $clusterString = '';
        $indent        = 1;

        foreach ($this->objects as $ns => $objects) {
            $undeclared     = false;
            $clusterString .= $this->formatLine('subgraph cluster_' . $cluster . ' {', $indent);
            $cluster++;

            $indent++;
            $clusterString .= $this->formatLine('label="' . str_replace('\\', '\\\\', $ns) . '";', $indent);

            foreach ($objects as $shortName => $values) {
                $clusterString .= $this->formatLine($values['pre'], $indent);
                if ($values['undeclared']) {
                    $undeclared = true;
                }
            }

            if ($undeclared) {
                // set background-color of undeclared namespace elements
                $clusterString .= $this->formatLine('bgcolor="#EB937F";', $indent);
            }

            $indent--;
            $clusterString .= $this->formatLine('}', $indent);
        }
        return $clusterString;
    }

    /**
     * Renders all edges (extends, implements) connecting objects
     *
     * @param int $indent Indent multiplier
     *
     * @return string
     */
    protected function renderEdges($indent = 1)
    {
        return parent::renderEdges($indent);
    }

    /**
     * Prints header of the main graph
     *
     * @return string
     */
    protected function writeGraphHeader()
    {
        $nodeAttributes = array(
            'fontname'  => "Verdana",
            'fontsize'  => 8,
            'shape'     => "none",
            'margin'    => 0,
            'fillcolor' => '#FEFECE',
            'style'     => 'filled',
        );

        $edgeAttributes = array(
            'fontname'  => "Verdana",
            'fontsize'  => 8,
        );

        $indent = 1;

        $graph  = $this->formatLine('digraph ' . $this->graphId . ' {');
        $graph .= $this->formatLine('overlap = false;', $indent);
        $graph .= $this->formatLine('node [' . $this->attributes($nodeAttributes) . '];', $indent);
        $graph .= $this->formatLine('edge [' . $this->attributes($edgeAttributes) . '];', $indent);

        return $graph;
    }

    /**
     * Prints footer of the main graph
     *
     * @return string
     */
    protected function writeGraphFooter()
    {
        return $this->formatLine('}');
    }

    /**
     * {@inheritdoc}
     */
    protected function pushObject(
        $ns,
        $shortName,
        $longName,
        $type,
        $stereotype = '',
        $undeclared = true,
        $constants = array(),
        $properties = array(),
        $methods = array()
    ) {
        $attributes  = '';

        $attributes .= $this->writeConstantElements(
            $constants,
            '<tr><td align="left">%s %s</td></tr>',
            0
        );

        $attributes .= $this->writePropertyElements(
            $properties,
            '<tr><td align="left">%s %s</td></tr>',
            0
        );

        if (empty($attributes)) {
            $attributes = ' ';
        } else {
            $attributes = sprintf(
                "<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n%s</table>",
                $attributes
            );
        }

        if (empty($methods) || $undeclared) {
            $operations = ' ';
        } else {
            $operations = sprintf(
                "<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n%s</table>",
                $this->writeMethodElements(
                    $methods,
                    '<tr><td align="left">%s%s()</td></tr>',
                    0
                )
            );
        }
        $label = sprintf(
            '
<table border="0" cellborder="1" cellspacing="0">
<tr><td align="center">%s<br/><b>%s</b></td></tr>
<tr><td>%s</td></tr>
<tr><td>%s</td></tr>
</table>
',
            $this->formatClassStereotype($type),
            $shortName,
            $attributes,
            $operations
        );

        $this->objects[$ns][$shortName] = array(
            'undeclared' => $undeclared,
            'pre'        => '"' . str_replace('\\', '\\\\', $longName) . '"' .
                ' [label=<' . $label . '>];'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function pushEdge(array $list, array $attributes = array())
    {
        $escape = function ($value) {
            return '"' . str_replace('\\', '\\\\', $value). '"';
        };
        $list = array_map($escape, $list);
        $edge = implode(' -> ', $list);

        $this->edges[] = $edge .
            ($attributes ? ' [' . $this->attributes($attributes) . ']' : '') .
            ";"
        ;
    }

    private function attributes(array $attr)
    {
        $exp = array();
        foreach ($attr as $name => $value) {
            $exp[] = $name . '="' . $value . '"';
        }
        return implode(', ', $exp);
    }
}
