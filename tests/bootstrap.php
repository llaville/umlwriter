<?php

$loader = require dirname(__DIR__) . '/vendor/autoload.php';
$loader->addClassMap(
    [
        // Fixture(s) resource(s)
        'FixtureOne\\OneClass' => __DIR__ . '/fixtures/001_simpleClass.php',
        'FixtureTwo\\OneClass' => __DIR__ . '/fixtures/002_simpleClassExtends.php',
        'FixtureTwo\\TwoClass' => __DIR__ . '/fixtures/002_simpleClassExtends.php',
        'FixtureThree\\OneInterface' => __DIR__ . '/fixtures/003_simpleClassImplements.php',
        'FixtureThree\\TwoInterface' => __DIR__ . '/fixtures/003_simpleClassImplements.php',
        'FixtureThree\\OneClass' => __DIR__ . '/fixtures/003_simpleClassImplements.php',
        'FixtureThree\\TwoClass' => __DIR__ . '/fixtures/003_simpleClassImplements.php',
        'FixtureFour\\OneClass' => __DIR__ . '/fixtures/004_Method.php',
        'FixtureFive\\ParentClass' => __DIR__ . '/fixtures/005_InheritMethod.php',
        'FixtureFive\\ExtendingClass' => __DIR__ . '/fixtures/005_InheritMethod.php',
        'FixtureSix\\OneClass' => __DIR__ . '/fixtures/006_Constant.php',
        'FixtureSeven\\ParentClass' => __DIR__ . '/fixtures/007_InheritConstant.php',
        'FixtureSeven\\ExtendingClass' => __DIR__ . '/fixtures/007_InheritConstant.php',
        'FixtureEight\\OneClass' => __DIR__ . '/fixtures/008_Property.php',
        // Issue(s) resource(s)
        'ltta\\model\\BackupProject' => __DIR__ . '/issues/gh-7.php',
        'App\\Foo' => __DIR__ . '/issues/when-dot-not-installed.php',
    ]
);
