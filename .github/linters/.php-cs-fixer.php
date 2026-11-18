<?php

$projectDir = dirname(__DIR__, 2);

$finder = (new PhpCsFixer\Finder())
    ->in([
        $projectDir . '/examples',
        $projectDir . '/resources',
        $projectDir . '/src',
    ])
;

return (new PhpCsFixer\Config())
    // allow to run on unsupported PHP Versions
    // {@link https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/README.md#supported-php-versions}
    // available since PHP-CS-Fixer 3.76.0
    // use instead `PHP_CS_FIXER_IGNORE_ENV` env var for older versions
    ->setUnsupportedPhpVersionAllowed(true)
    // use default @link https://www.php-fig.org/per/coding-style/
    ->registerCustomFixers(
        new PhpCsFixerCustomFixers\Fixers()
    )
    ->setRules([
        '@PHP8x3Migration' => true,
        PhpCsFixerCustomFixers\Fixer\TypedClassConstantFixer::name() => true,
    ])
    // default source code to scan
    ->setFinder($finder)
;
