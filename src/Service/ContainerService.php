<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\UmlWriter\Service;

use Bartlett\UmlWriter\Console\Command\ClassDiagramCommand;
use Bartlett\UmlWriter\Generator\GeneratorFactory;
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

/**
 * @author Laurent Laville
 */
class ContainerService implements ContainerInterface
{
    /**
     * @var array<string, mixed>
     */
    private array $internalServices = [
        ClassDiagramCommand::class => null,
        ClassDiagramRenderer::class => null,
        GeneratorFactoryInterface::class => null,
    ];

    /**
     * Services allowed at runtime
     * @var array<string, mixed>
     */
    private array $runtimeServices = [
        InputInterface::class => null,
        OutputInterface::class => null,
    ];

    public function __construct()
    {
        $this->runtimeServices[GeneratorFactoryInterface::class] = function () {
            return new GeneratorFactory();
        };

        $this->internalServices[ClassDiagramRenderer::class] = function () {
            return new ClassDiagramRenderer();
        };
        $this->internalServices[ClassDiagramCommand::class] = function () {
            return new ClassDiagramCommand(
                $this->get(ClassDiagramRenderer::class),
                $this->get(GeneratorFactoryInterface::class)
            );
        };
    }

    public function set(string $id, mixed $service): void
    {
        if (!array_key_exists($id, $this->runtimeServices)) {
            throw new class (
                sprintf('The "%s" runtime service is not expected.', $id)
            ) extends RuntimeException implements ContainerExceptionInterface {
            };
        }

        $this->runtimeServices[$id] = $service;
    }

    public function get(string $id): mixed
    {
        if (isset($this->runtimeServices[$id])) {
            return call_user_func($this->runtimeServices[$id]);
        }

        if (isset($this->internalServices[$id])) {
            return call_user_func($this->internalServices[$id]);
        }

        throw new class (
            sprintf('The "%s" service is not registered in the service container.', $id)
        ) extends RuntimeException implements NotFoundExceptionInterface {
        };
    }

    public function has(string $id): bool
    {
        return isset($this->internalServices[$id]) || isset($this->runtimeServices[$id]);
    }
}
