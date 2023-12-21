<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link https://www.tomasvotruba.cz/blog/2018/08/02/5-gotchas-of-the-bin-file-in-php-cli-applications/
 */

gc_disable(); // performance boost

$autoloader = 'vendor/autoload.php';

if (Phar::running()) {
    $phar = new Phar($_SERVER['argv'][0]);
    $possibleAutoloadPaths = [
        'phar://' . $phar->getAlias(),
    ];

} else {
    $possibleAutoloadPaths = [
        // local dev repository
        __DIR__,
        // dependency
        dirname(__DIR__, 3),
    ];
}

$isAutoloadFound = false;
foreach ($possibleAutoloadPaths as $possibleAutoloadPath) {
    if (file_exists($possibleAutoloadPath . DIRECTORY_SEPARATOR . $autoloader)) {
        require_once $possibleAutoloadPath . DIRECTORY_SEPARATOR . $autoloader;
        $isAutoloadFound = true;
        break;
    }
}

if ($isAutoloadFound === false) {
    throw new RuntimeException(
        sprintf(
            'Unable to find "%s" in "%s" paths.',
            $autoloader,
            implode('", "', $possibleAutoloadPaths)
        )
    );
}
