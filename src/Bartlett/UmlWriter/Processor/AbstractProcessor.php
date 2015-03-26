<?php
/**
 * Abstract UML diagram processor
 *
 * PHP version 5
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  GIT: $Id$
 * @link     http://php5.laurent-laville.org/umlwriter/
 */

namespace Bartlett\UmlWriter\Processor;

use Bartlett\UmlWriter\Reflector\ReflectorInterface;

/**
 * Abstract UML diagram processor
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  Release: @package_version@
 * @link     http://php5.laurent-laville.org/umlwriter/
 * @since    Class available since Release 1.0.0-RC1
 */
abstract class AbstractProcessor
{
    protected $reflector;

    protected $graphId;
    protected $objects = array();
    protected $edges   = array();

    private $spaces    = "\t";
    private $linebreak = "\n";

    /**
     * Concrete processor constructor
     *
     * @param ReflectorInterface $reflector Reverse engine
     */
    public function __construct(ReflectorInterface $reflector)
    {
        $this->reflector = $reflector;
        $this->setGraphId();
    }

    /**
     * Sets the current graph identifier.
     *
     * @param string $id (optional) Graph identifier
     *
     * @return self for fluent interface
     */
    public function setGraphId($id = 'G')
    {
        $this->graphId = $id;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function renderClass($className)
    {
        $this->reset();

        $this->writeObjectElement(
            $this->reflector->getClass($className)
        );
        return $this->render();
    }

    /**
     * {@inheritdoc}
     */
    public function renderNamespace($namespaceName)
    {
        $this->reset();

        foreach ($this->reflector->getNamespace($namespaceName) as $object) {
            $this->writeObjectElement($object);
        }
        return $this->render();
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        // starts main graph
        $graph = $this->writeGraphHeader();

        // one or more namespace/object
        if (empty($this->objects)) {
            $namespaces = array();

            foreach ($this->reflector->getClasses() as $class) {
                $ns = $class->getNamespaceName();
                if (in_array($ns, $namespaces)) {
                    continue;
                }
                $namespaces[] = $ns;

                // proceed objects of a same namespace
                foreach ($this->reflector->getNamespace($ns) as $object) {
                    $this->writeObjectElement($object);
                }
            }
        }

        // prints all namespaces with objects
        $graph .= $this->renderObjects();

        // prints all edges
        $graph .= $this->renderEdges();

        // ends main graph
        $graph .= $this->writeGraphFooter();

        return $graph;
    }

    /**
     * Renders all edges (extends, implements) connecting objects
     *
     * @param int $indent Indent multiplier (greater or equal to zero)
     *
     * @return string
     */
    protected function renderEdges($indent)
    {
        $edgeString = '';
        foreach (array_unique($this->edges) as $edge) {
            $edgeString .= $this->formatLine($edge, $indent);
        }
        return $edgeString;
    }

    /**
     * Formats a line
     */
    protected function formatLine($string, $indent = 0)
    {
        return str_repeat($this->spaces, $indent) . $string . $this->linebreak;
    }

    /**
     * Prints class/interface/trait
     *
     * @param ReflectionClass $object class/interface/trait instance
     */
    protected function writeObjectElement($object)
    {
        $stereotype = '';

        if ($object->isTrait()) {
            $type = 'class';
            $stereotype = '<< (T,#FF7700) trait >>';
        } elseif ($object->isInterface()) {
            $type = 'interface';
        } elseif ($object->isAbstract()) {
            $type = 'abstract';
        } else {
            $type = 'class';
        }

        $this->pushObject(
            $object->getNamespaceName(),
            $object->getShortName(),
            $object->getName(),
            $type,
            $stereotype,
            false,
            $object->getConstants(),
            $object->getProperties(),
            $object->getMethods()
        );

        // prints inheritance (if exists)
        $parentName = $object->getParentClassName();
        if ($parentName) {
            $this->writeObjectInheritance($object, $parentName);
        }

        // prints interfaces (if exists)
        $interfaces = $object->getInterfaceNames();
        if (count($interfaces)) {
            $this->writeObjectInterfaces($object, $interfaces);
        }
    }

    /**
     * Prints an object inheritance
     *
     * @param ReflectionClass $object class/interface instance
     * @param string          $parentName Fully qualified name of the parent
     *
     * @return void
     */
    protected function writeObjectInheritance($object, $parentName)
    {
        try {
            $parent      = $this->reflector->getClass($parentName);
            $longName    = $parent->getName();

            $this->writeObjectElement($parent);

        } catch (\Exception $e) {
            // object is undeclared in data source
            $parts       = explode('\\', $parentName);
            $shortName   = array_pop($parts);
            $longName    = $parentName;
            $ns          = implode($this->namespaceSeparator, $parts);

            if (!isset($this->objects[$ns])) {
                $this->objects[$ns] = array();
            }

            if (!array_key_exists($shortName, $this->objects[$ns])) {
                $type = $object->isInterface() ? 'interface' : 'class';
                $this->pushObject($ns, $shortName, $longName, $type);
            }
        }

        $this->pushEdge(array($object->getName(), $longName));
    }

    /**
     * Prints interfaces that implement an object
     *
     * @param ReflectionClass $object     class/interface instance
     * @param array           $interfaces Names of each interface implemented
     *
     * @return void
     */
    protected function writeObjectInterfaces($object, $interfaces)
    {
        foreach ($interfaces as $interfaceName) {
            try {
                $interface   = $this->reflector->getClass($interfaceName);
                $longName    = $interface->getName();

                $this->writeObjectElement($interface);

            } catch (\Exception $e) {
                // interface is undeclared in data source
                $parts       = explode('\\', $interfaceName);
                $shortName   = array_pop($parts);
                $longName    = $interfaceName;
                $ns          = implode($this->namespaceSeparator, $parts);

                if (!isset($this->objects[$ns])) {
                    $this->objects[$ns] = array();
                }

                if (!array_key_exists($shortName, $this->objects[$ns])) {
                    $this->pushObject($ns, $shortName, $longName, 'interface');
                }
            }

            $this->pushEdge(
                array($object->getName(), $longName),
                array('arrowhead' => 'empty', 'style' => 'dashed')
            );
        }
    }

    /**
     * Prints class constants
     *
     * @param ReflectionConstant[] $constants List of constant instance
     * @param string               $format    (optional) Constant formatter
     * @param int                  $indent    (optional) Indent multiplier
     *
     * @return string
     */
    protected function writeConstantElements($constants, $format = '%s %s\l', $indent = -1)
    {
        $constantString = '';

        foreach ($constants as $name => $value) {
            $line = sprintf($format, '+', $name);
            if ($indent >= 0) {
                $constantString .= $this->formatLine($line, $indent);
            } else {
                $constantString .= $line;
            }
        }
        return $constantString;
    }

    /**
     * Prints class properties
     *
     * @param ReflectionProperty[] $properties List of property instance
     * @param string               $format     (optional) Property formatter
     * @param int                  $indent     (optional) Indent multiplier
     *
     * @return string
     */
    protected function writePropertyElements($properties, $format = '%s %s\l', $indent = -1)
    {
        $propertyString = '';

        foreach ($properties as $property) {
            if ($property->isPrivate()) {
                $visibility = '-';
            } elseif ($property->isProtected()) {
                $visibility = '#';
            } else {
                $visibility = '+';
            }

            $line = sprintf(
                $format,
                $visibility,
                $property->getName()
            );
            if ($indent >= 0) {
                $propertyString .= $this->formatLine($line, $indent);
            } else {
                $propertyString .= $line;
            }
        }
        return $propertyString;
    }

    /**
     * Prints class methods
     *
     * @param ReflectionMethod[] $methods List of method instance
     * @param string             $format  (optional) Method formatter
     * @param int                $indent  (optional) Indent multiplier
     *
     * @return string
     */
    protected function writeMethodElements($methods, $format = '%s %s()\l', $indent = -1)
    {
        $methodString = '';

        foreach ($methods as $method) {
            if ($method->isPrivate()) {
                $visibility = '-';
            } elseif ($method->isProtected()) {
                $visibility = '#';
            } else {
                $visibility = '+';
            }

            if ($method->isStatic()) {
                $modifier = '<u>%s</u>';
            } elseif ($method->isAbstract()) {
                $modifier = '<i>%s</i>';
            } else {
                $modifier = '%s';
            }

            $line = sprintf(
                $format,
                $visibility,
                sprintf($modifier, $method->getShortName())
            );
            if ($indent >= 0) {
                $methodString .= $this->formatLine($line, $indent);
            } else {
                $methodString .= $line;
            }
        }
        return $methodString;
    }

    /**
     * Creates a new vertex on graph
     *
     * @return void
     */
    abstract protected function pushObject(
        $ns,
        $shortName,
        $longName,
        $type,
        $stereotype = '',
        $undeclared = true,
        $constants = array(),
        $properties = array(),
        $methods = array()
    );

    /**
     * Creates a new edge on graph
     *
     * @param array $list       List of edges
     * @param array $attributes Attributes to set on edge
     *
     * @return void
     */
    abstract protected function pushEdge(array $list, array $attributes = array());

    protected function formatClassStereotype($stereotype)
    {
        $this->colors['classStereotypeFontColor'] = '<font color="black">%s</font>';
        $this->colors['classStereotypeFontSize']  =  12;
        $this->colors['classStereotypeFontStyle'] = '<i>%s</i>';

        $stereotype = sprintf(
            $this->colors['classStereotypeFontStyle'],
            $stereotype
        );
        $stereotype = sprintf(
            $this->colors['classStereotypeFontColor'],
            $stereotype
        );
        return sprintf('&lt;&lt; %s &gt;&gt;', $stereotype);
    }

    private function reset()
    {
        $this->objects = array();
        $this->edges   = array();
    }
}
