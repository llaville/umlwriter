<?php

namespace Name\Space;

class Bar
{
    protected $inheritedProperty = 'inheritedDefault';      // @phpstan-ignore-line
}

// phpcs:disable
class Foo extends Bar
{
    public $property = 'propertyDefault';                   // @phpstan-ignore-line
    private $privateProperty = 'privatePropertyDefault';    // @phpstan-ignore-line
    public static $staticProperty = 'staticProperty';       // @phpstan-ignore-line
    public $defaultlessProperty;                            // @phpstan-ignore-line
    protected static $defaultName;                          // @phpstan-ignore-line
}
// phpcs:enable
