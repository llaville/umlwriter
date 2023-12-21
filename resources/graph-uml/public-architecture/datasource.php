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

return function (): Generator
{
    $classes = [
        GeneratorFactory::class,
        ConfigurationHandler::class,
        ClassDiagramRenderer::class,
        ContainerService::class,
        Application::class,
        ClassDiagramCommand::class,
        YamlFileLoader::class,
    ];
    foreach ($classes as $class) {
        yield $class;
    }
};
