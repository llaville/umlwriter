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

use Bartlett\UmlWriter\Service\ConfigurationHandler;

use Symfony\Component\Finder\Finder;

return function (): Finder
{
    $config = (new ConfigurationHandler(__DIR__ . '/.umlwriter.yaml'))->toArray();

    $finder = new Finder();
    $finder->name('*.php');

    foreach ($config['paths'] as $path) {
        if (is_dir($path)) {
            $finder->in($path);
        } else {
            $finder->in(dirname($path));
        }
    }

    return $finder;
};
