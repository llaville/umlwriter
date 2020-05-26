<?php
/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require dirname(__DIR__, 2) . '/vendor/autoload.php';
$loader->addClassMap(
    [
        'Name\\Space\\Foo' => __DIR__ . '/reflection-properties.php',
        'Name\\Space\\Bar' => __DIR__ . '/reflection-properties.php',
    ]
);
