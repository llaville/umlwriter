<?php
/**
 * The UmlWriter CLI version.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  GIT: $Id$
 * @link     http://php5.laurent-laville.org/umlwriter/
 */

namespace Bartlett\UmlWriter\Console;

use Bartlett\UmlWriter\Console\Command\DiagramRender;
use Bartlett\UmlWriter\Console\Command\DiagramRenderClass;
use Bartlett\UmlWriter\Console\Command\DiagramRenderNamespace;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Console Application.
 *
 * @category PHP
 * @package  UmlWriter
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  Release: @package_version@
 * @link     http://php5.laurent-laville.org/umlwriter/
 * @since    Class available since Release 1.0.0-RC2
 */
class Application extends BaseApplication
{
    /**
     * @link http://patorjk.com/software/taag/#p=display&f=Standard&t=umlWriter
     */
    protected static $logo = "                  ___        __    _ _
  _   _ _ __ ___ | \ \      / / __(_) |_ ___ _ __
 | | | | '_ ` _ \| |\ \ /\ / / '__| | __/ _ \ '__|
 | |_| | | | | | | | \ V  V /| |  | | ||  __/ |
  \__,_|_| |_| |_|_|  \_/\_/ |_|  |_|\__\___|_|

";

    private $release;

    /**
     * Constructor.
     *
     * @param string $appName    The name of the application
     * @param string $appVersion The version of the application
     */
    public function __construct($appName, $appVersion)
    {
        // disable Garbage Collector
        gc_disable();

        parent::__construct($appName, '@package_version@');
        $this->release = $appVersion;
    }

    /**
     * {@inheritDoc}
     */
    public function getHelp()
    {
        return '<comment>' . static::$logo . '</comment>' . parent::getHelp();
    }

    /**
     * {@inheritDoc}
     */
    public function getVersion()
    {
        $version = parent::getVersion();

        if ('@' . 'package_version@' == $version) {
            $version = new \SebastianBergmann\Version(
                $this->release,
                dirname(dirname(dirname(dirname(__DIR__))))
            );
            $version = $version->getVersion();
        }
        return $version;
    }

    /**
     * Gets the application version (long format).
     *
     * @return string The application version
     */
    public function getLongVersion()
    {
        return sprintf(
            '<info>%s</info> version <comment>%s</comment>',
            $this->getName(),
            $this->getVersion()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        if (\Phar::running()
            && true === $input->hasParameterOption('--manifest')
        ) {
            $manifest = 'phar://' . strtolower($this->getName()) . '.phar/manifest.txt';

            if (file_exists($manifest)) {
                $out = file_get_contents($manifest);
                $exitCode = 0;
            } else {
                $fmt = $this->getHelperSet()->get('formatter');
                $out = $fmt->formatBlock('No manifest defined', 'error');
                $exitCode = 1;
            }
            $output->writeln($out);
            return $exitCode;
        }

        $exitCode = parent::doRun($input, $output);

        return $exitCode;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();
        if (\Phar::running()) {
            $definition->addOption(
                new InputOption(
                    '--manifest',
                    null,
                    InputOption::VALUE_NONE,
                    'Show which versions of dependencies are bundled.'
                )
            );
        }
        return $definition;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();

        $defaultCommands[] = new DiagramRender();
        $defaultCommands[] = new DiagramRenderClass();
        $defaultCommands[] = new DiagramRenderNamespace();

        return $defaultCommands;
    }
}
