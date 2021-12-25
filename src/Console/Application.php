<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
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

/**
 * @author Laurent Laville
 */
final class Application extends SymfonyApplication
{
    public const NAME = 'umlWriter';
    public const VERSION = '2.1.0';

    /**
     * @link http://patorjk.com/software/taag/#p=display&f=Standard&t=umlWriter
     * @var string
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
        $this->container->set(InputInterface::class, $input);                                   // @phpstan-ignore-line
        $this->container->set(OutputInterface::class, $output);                                 // @phpstan-ignore-line
        if (!$this->container->has(GeneratorFactoryInterface::class)) {
            $this->container->set(GeneratorFactoryInterface::class, new GeneratorFactory());    // @phpstan-ignore-line
        }

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
