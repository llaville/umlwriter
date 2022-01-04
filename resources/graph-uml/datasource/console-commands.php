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

use Bartlett\UmlWriter\Console\Application;
use Bartlett\UmlWriter\Console\Command\ClassDiagramCommand;

use Symfony\Component\Console\Application as SymfonyApplication;

function dataSource(): Generator
{
    $classes = [
        Application::class,
        ClassDiagramCommand::class,

        SymfonyApplication::class,
    ];
    foreach ($classes as $class) {
        yield $class;
    }
}
