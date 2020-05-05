<?php
declare(strict_types=1);

namespace Bartlett\UmlWriter\Service;

use Bartlett\UmlWriter\Console\Command\ClassDiagramCommand;
use Bartlett\UmlWriter\Generator\GeneratorFactoryInterface;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use RuntimeException;

use function array_key_exists;
use function call_user_func;
use function sprintf;

class ContainerService implements ContainerInterface
{
    private $internalServices = [
        ClassDiagramCommand::class => null,
        ClassDiagramRenderer::class => null,
    ];

    // Services allowed at runtime
    private $runtimeServices = [
        InputInterface::class => null,
        OutputInterface::class => null,
        GeneratorFactoryInterface::class => null,
    ];

    public function __construct()
    {
        $this->internalServices[ClassDiagramRenderer::class] = function() {
            return new ClassDiagramRenderer();
        };
        $this->internalServices[ClassDiagramCommand::class] = function() {
            return new ClassDiagramCommand(
                $this->get(ClassDiagramRenderer::class),
                $this->get(GeneratorFactoryInterface::class)
            );
        };
    }

    public function set(string $id, $service): void
    {
        if (!array_key_exists($id, $this->runtimeServices)) {
            throw new class(
                sprintf('The "%s" runtime service is not expected.', $id)
            ) extends RuntimeException implements ContainerExceptionInterface {};
        }

        $this->runtimeServices[$id] = $service;
    }

    public function get($id)
    {
        if (isset($this->runtimeServices[$id])) {
            return $this->runtimeServices[$id];
        }

        if (isset($this->internalServices[$id])) {
            return call_user_func($this->internalServices[$id]);
        }

        throw new class(
            sprintf('The "%s" service is not registered in the service container.', $id)
        ) extends RuntimeException implements NotFoundExceptionInterface {};
    }

    public function has($id)
    {
        return isset($this->internalServices[$id]) || isset($this->runtimeServices[$id]);
    }
}
