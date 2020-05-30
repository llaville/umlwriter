<?php
/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require dirname(__DIR__, 2) . '/vendor/autoload.php';
$loader->addClassMap(
    [
        'Name\\Space\\MyGeneratorFactory' => __DIR__ . '/my-generator-factory.php',
        'Name\\Space\\MyGenerator' => __DIR__ . '/my-generator.php',
    ]
);
