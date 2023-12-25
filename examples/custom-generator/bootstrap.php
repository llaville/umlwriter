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

use Composer\Autoload\ClassLoader;

return function (): void
{
    /** @var ClassLoader $loader */
    $loader = require dirname(__DIR__, 2) . '/vendor/autoload.php';
    $loader->addClassMap(
        [
            'Name\\Space\\MyGenerator' => __DIR__ . '/resources.php',
            'Name\\Space\\MyGeneratorFactory' => __DIR__ . '/resources.php',
        ]
    );
};
