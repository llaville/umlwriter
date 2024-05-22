<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\UmlWriter;

/**
 * @author Laurent Laville
 * @since Release 4.1.0
 */
if (class_exists(__NAMESPACE__ . '\Autoload', false) === false) {
    class Autoload
    {
        /**
         * The composer autoloader.
         *
         * @var \Composer\Autoload\ClassLoader
         */
        private static $composerAutoloader = null;

        public static function load(string $class): void
        {
            if (self::$composerAutoloader === null) {
                self::$composerAutoloader = require self::getAutoloadFile();
            }

            self::$composerAutoloader->loadClass($class);
        }

        private static function getAutoloadFile(): string
        {
            if (isset($GLOBALS['_composer_autoload_path'])) {
                $possibleAutoloadPaths = [
                    dirname($GLOBALS['_composer_autoload_path'])
                ];
                $autoloader = basename($GLOBALS['_composer_autoload_path']);
            } else {
                $possibleAutoloadPaths = [
                    // local dev repository
                    __DIR__,
                    // dependency
                    dirname(__DIR__, 3),
                ];
                $autoloader = 'vendor/autoload.php';
            }

            foreach ($possibleAutoloadPaths as $possibleAutoloadPath) {
                if (file_exists($possibleAutoloadPath . DIRECTORY_SEPARATOR . $autoloader)) {
                    return $possibleAutoloadPath . DIRECTORY_SEPARATOR . $autoloader;
                }
            }

            throw new \RuntimeException(
                sprintf(
                    'Unable to find "%s" in "%s" paths.',
                    $autoloader,
                    implode('", "', $possibleAutoloadPaths)
                )
            );
        }
    }

    spl_autoload_register(__NAMESPACE__ . '\Autoload::load', true, true);
}
