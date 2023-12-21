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

use Symfony\Component\Finder\Finder;

return function (): Finder
{
    // path to directory where to find PHP source code
    $dataSource1 = dirname(__DIR__, 2) . '/src/Config';
    $dataSource2 = dirname(__DIR__, 2) . '/src/Service';

    $finder = new Finder();
    $finder->in($dataSource1)->name('*.php');
    $finder->append((new Finder())->in($dataSource2)->name('ConfigurationHandler.php'));

    return $finder;
};
