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

use Bartlett\UmlWriter\Config\Loader\YamlFileLoader;
use Bartlett\UmlWriter\Service\ConfigurationHandler;

function dataSource(): Generator
{
    $classes = [
        YamlFileLoader::class,
        ConfigurationHandler::class,
    ];
    foreach ($classes as $class) {
        yield $class;
    }
}
