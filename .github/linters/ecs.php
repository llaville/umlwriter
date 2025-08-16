<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

$projectDir = dirname(__DIR__, 2);

return ECSConfig::configure()
    ->withPaths([
        $projectDir . '/examples',
        $projectDir . '/resources',
        $projectDir . '/src',
        $projectDir . '/tests',
    ])

    // add a single rule
    ->withRules([
        NoUnusedImportsFixer::class,
    ])

    // add sets - group of rules, from easiest to more complex ones
    ->withPreparedSets(
        spaces: true,
    )
;
