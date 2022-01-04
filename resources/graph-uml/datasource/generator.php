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

require_once dirname(__DIR__, 3) . '/examples/generator/classmap.php';

function dataSource(): Generator
{
    $classes = [
        \Name\Space\MyGeneratorFactory::class,
        \Name\Space\MyGenerator::class,
    ];
    foreach ($classes as $class) {
        yield $class;
    }
}
