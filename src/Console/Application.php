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

use Composer\InstalledVersions;

use Psr\Container\ContainerInterface;

use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\CommandLoader\ContainerCommandLoader;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

use Phar;

/**
 * @author Laurent Laville
 */
final class Application extends SymfonyApplication
{
    public const NAME = 'umlWriter';

    /**
     * @link http://patorjk.com/software/taag/#p=display&f=Standard&t=umlWriter
     */
    protected static string $logo = "                  ___        __    _ _
  _   _ _ __ ___ | \ \      / / __(_) |_ ___ _ __
 | | | | '_ ` _ \| |\ \ /\ / / '__| | __/ _ \ '__|
 | |_| | | | | | | | \ V  V /| |  | | ||  __/ |
  \__,_|_| |_| |_|_|  \_/\_/ |_|  |_|\__\___|_|

";

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct(
            self::NAME,
            $this->getInstalledVersion(false)
        );

        $this->container = $container;
        $this->setCommandLoader($this->createCommandLoader($container));
    }

    /**
     * {@inheritDoc}
     */
    public function getHelp(): string
    {
        return sprintf(
            '<comment>%s</comment><info>%s</info> version <comment>%s</comment>',
            self::$logo,
            $this->getName(),
            $this->getVersion()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getLongVersion(): string
    {
        return $this->getInstalledVersion();
    }

    /**
     * {@inheritDoc}
     */
    public function doRun(InputInterface $input, OutputInterface $output): int
    {
        $this->container->set(InputInterface::class, $input);                                   // @phpstan-ignore-line
        $this->container->set(OutputInterface::class, $output);                                 // @phpstan-ignore-line
        if (!$this->container->has(GeneratorFactoryInterface::class)) {
            $this->container->set(GeneratorFactoryInterface::class, new GeneratorFactory());    // @phpstan-ignore-line
        }

        return parent::doRun($input, $output);
    }

    /**
     * {@inheritDoc}
     */
    public function run(InputInterface $input = null, OutputInterface $output = null): int
    {
        if (null === $input) {
            if ($this->container->has(InputInterface::class)) {
                $input = $this->container->get(InputInterface::class);
            } else {
                $input = new ArgvInput();
            }
        }

        if (null === $output) {
            if ($this->container->has(OutputInterface::class)) {
                $output = $this->container->get(OutputInterface::class);
            } else {
                $output = new ConsoleOutput();
            }
        }

        if ($input->hasParameterOption('--manifest')) {
            $phar = new Phar($_SERVER['argv'][0]);
            $manifest = $phar->getMetadata();
            $output->writeln($manifest);
            return 0;
        }

        return parent::run($input, $output);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultInputDefinition(): InputDefinition
    {
        $definition = parent::getDefaultInputDefinition();
        if (Phar::running()) {
            $definition->addOption(
                new InputOption(
                    'manifest',
                    null,
                    InputOption::VALUE_NONE,
                    'Show which versions of dependencies are bundled'
                )
            );
        }
        return $definition;
    }

    /**
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

    private function getInstalledVersion(bool $withRef = true): string
    {
        $packageName = 'bartlett/umlwriter';

        $version = InstalledVersions::getPrettyVersion($packageName);
        if (!$withRef) {
            return $version;
        }
        $commitHash = InstalledVersions::getReference($packageName);
        return sprintf('%s@%s', $version, substr($commitHash, 0, 7));
    }
}
