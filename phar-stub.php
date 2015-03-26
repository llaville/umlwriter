#!/usr/bin/env php
<?php
if (class_exists('Phar')) {
    $mapName = 'umlwriter';

    Phar::mapPhar($mapName . '.phar');

    require 'phar://' . __FILE__ . '/bin/' . $mapName;
}
__HALT_COMPILER();