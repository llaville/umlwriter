<?php
declare(strict_types=1);

namespace Bartlett\UmlWriter\Console;

use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\UmlWriter\Service\ClassDiagramRenderer;

use Symfony\Component\Console\Application as SymfonyApplication;

class Application extends SymfonyApplication
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

    /**
     * {@inheritDoc}
     */
    public function getHelp()
    {
        return '<comment>' . static::$logo . '</comment>' . parent::getHelp();
    }

    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();

        $defaultCommands[] = new Command\ClassDiagramCommand(
            new ClassDiagramRenderer(),
            new GeneratorFactory()
        );

        return $defaultCommands;
    }
}
