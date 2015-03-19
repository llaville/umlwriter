<?php
/**
 * Examples of PlantUML class diagrams
 *
 * PHP version 5
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  GIT: $Id$
 * @link     http://php5.laurent-laville.org/umlwriter/
 * @since    Example available since Release 1.0.0-RC1
 */

$vendor = dirname(__DIR__) . '/vendor';

require_once $vendor . '/autoload.php';

// path to directory where to find PHP source code
$dataSource = dirname(__DIR__) . '/src/Bartlett/UmlWriter';
// $dataSource = $vendor . '/bartlett/php-reflect/src';

// uses Bartlett\Reflect as reverse engine
$reflector = new Bartlett\UmlWriter\Reflector\Reflect($dataSource);

// you may also used Andrewsville\TokenReflection reverse engine
// $reflector = new Bartlett\UmlWriter\Reflector\TokenReflection($dataSource);

// creates a new instance of PlantUML processor
$processor = new Bartlett\UmlWriter\Processor\PlantUMLProcessor($reflector);

// generates UML class diagram of all objects in the Bartlett\UmlWriter\Processor namespace
$g = $processor->setGraphId('G1')->renderNamespace('Bartlett\UmlWriter\Processor');

// prints results in STDOUT
echo $g;

// you may also, writes results to a file
$filename = tempnam(__DIR__ . '/out', 'plantuml_');
file_put_contents($filename, $g);
