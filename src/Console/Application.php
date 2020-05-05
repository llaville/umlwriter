<?php
declare(strict_types=1);

namespace Bartlett\UmlWriter\Console;

use Bartlett\UmlWriter\Console\Command\ClassDiagramCommand;
use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Generator\GeneratorFactoryInterface;

use Psr\Container\ContainerInterface;

use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\CommandLoader\ContainerCommandLoader;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Application extends SymfonyApplication
{
    public const NAME = 'umlWriter';
    public const VERSION = '2.0.0-dev';

    /**
     * @link http://patorjk.com/software/taag/#p=display&f=Standard&t=umlWriter
     */
    protected static $logo = "                  ___        __    _ _
  _   _ _ __ ___ | \ \      / / __(_) |_ ___ _ __
 | | | | '_ ` _ \| |\ \ /\ / / '__| | __/ _ \ '__|
 | |_| | | | | | | | \ V  V /| |  | | ||  __/ |
  \__,_|_| |_| |_|_|  \_/\_/ |_|  |_|\__\___|_|

";

    /** @var ContainerInterface  */
    private $container;

    public function __construct(ContainerInterface $container, string $version = self::VERSION)
    {
        parent::__construct(self::NAME, $version);

        $this->container = $container;
        $this->setCommandLoader($this->createCommandLoader($container));
    }

    /**
     * {@inheritDoc}
     */
    public function getHelp()
    {
        return '<comment>' . static::$logo . '</comment>' . parent::getHelp();
    }

    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $this->container->set(InputInterface::class, $input);
        $this->container->set(OutputInterface::class, $output);
        $this->container->set(GeneratorFactoryInterface::class, new GeneratorFactory());

        return parent::doRun($input, $output);
    }

    /**
     * @param ContainerInterface $container
     * @return CommandLoaderInterface
     * @see https://symfony.com/doc/current/console/lazy_commands.html#containercommandloader
     */
    private function createCommandLoader(ContainerInterface $container): CommandLoaderInterface
    {
        return new ContainerCommandLoader(
            $container,
            [
                ClassDiagramCommand::NAME => ClassDiagramCommand::class,
            ]
        );
    }
}
