<?php

$loader = require dirname(__DIR__) . '/vendor/autoload.php';
$loader->addClassMap(
    [
        'ltta\\model\\BackupProject' => __DIR__ . '/issues/gh-7.php',
    ]
);
