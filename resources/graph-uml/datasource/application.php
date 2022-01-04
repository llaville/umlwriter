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
use Bartlett\UmlWriter\Console\Application;
use Bartlett\UmlWriter\Console\Command\ClassDiagramCommand;
use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;
use Bartlett\UmlWriter\Service\ConfigurationHandler;
use Bartlett\UmlWriter\Service\ContainerService;

use Psr\Container\ContainerInterface;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Contracts\Service\ResetInterface;
use Symfony\Component\Console\Application as SymfonyApplication;

function dataSource(): Generator
{
    $classes = [
        GeneratorFactory::class,
        ConfigurationHandler::class,
        ClassDiagramRenderer::class,
        ContainerService::class,
        Application::class,
        ClassDiagramCommand::class,
        YamlFileLoader::class,

        ResetInterface::class,
        LoaderInterface::class,
        Command::class,
        SymfonyApplication::class,
        ContainerInterface::class,
    ];
    foreach ($classes as $class) {
        yield $class;
    }
}
