<?php
/**
 * PlantUML diagram processor
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
 * Diagram processor for PlantUML engine (http://plantuml.sourceforge.net/)
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  Release: @package_version@
 * @link     http://php5.laurent-laville.org/umlwriter/
 * @since    Class available since Release 1.0.0-RC1
 */
class PlantUMLProcessor extends AbstractProcessor implements ProcessorInterface
{
    protected $namespaceSeparator = '.';

    /**
     * Prints all objects (class, interface, trait)
     *
     * @return string
     */
    protected function renderObjects()
    {
        $clusterString = '';

        foreach ($this->objects as $ns => $objects) {
            $undeclared = false;
            if (!empty($ns)) {
                $clusterString .= $this->formatLine('namespace ' . str_replace('\\', '.', $ns) . ' %fillcolor% {');
            }
            foreach ($objects as $shortName => $values) {
                $clusterString .= $values['pre'];
                if ($values['undeclared']) {
                    $undeclared = true;
                }
            }

            if (!empty($ns)) {
                if ($undeclared) {
                    // set background-color of undeclared namespace elements
                    $clusterString = str_replace('%fillcolor%', '#EB937F', $clusterString);
                } else {
                    $clusterString = str_replace('%fillcolor%', '', $clusterString);
                }

                $clusterString .= $this->formatLine('}');
            }
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
    protected function renderEdges($indent = 0)
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
        return $this->formatLine('@startuml');
    }

    /**
     * Prints footer of the main graph
     *
     * @return string
     */
    protected function writeGraphFooter()
    {
        return $this->formatLine('@enduml');
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
        if (empty($stereotype)) {
            $stereotype = sprintf('<< %s >>', $type);
        }

        $indent     = 1;
        $objectString = $this->formatLine(
            sprintf(
                '%s %s %s {',
                $type,
                $shortName,
                $stereotype
            ),
            $indent
        );
        $indent++;

        // prints class constants
        $objectString .= $this->writeConstantElements($constants, '%s%s', $indent);

        if (count($constants) && count($properties)) {
            // print separator between constants and properties
            $objectString .= $this->formatLine('..', $indent);
        }

        // prints class properties
        $objectString .= $this->writePropertyElements($properties, '%s%s', $indent);

        if (count($methods)
            && (count($properties) || count($constants))
        ) {
            // print separator between properties and methods or constants and methods
            $objectString .= $this->formatLine('--', $indent);
        }

        // prints class methods
        $objectString .= $this->writeMethodElements($methods, '%s%s()', $indent);

        $objectString .= $this->formatLine('}', --$indent);

        $this->objects[$ns][$shortName] = array(
            'undeclared' => $undeclared,
            'pre'        => $objectString
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function pushEdge(array $list, array $attributes = array())
    {
        $escape = function ($value) {
            return str_replace('\\', '.', $value);
        };
        $list = array_map($escape, $list);

        $arrow = ' --|> ';

        if (!empty($attributes)) {
            $arrow = $attributes['style'] == 'dashed' ? ' ..|> ' : $arrow;
        }
        $edge = implode($arrow, $list);

        $this->edges[] = $edge;
    }
}
