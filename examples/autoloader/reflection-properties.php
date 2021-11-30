<?php

namespace Name\Space;

class Bar
{
    protected $inheritedProperty = 'inheritedDefault';
}

// phpcs:disable
class Foo extends Bar
{
    public $property = 'propertyDefault';
    private $privateProperty = 'privatePropertyDefault';
    public static $staticProperty = 'staticProperty';
    public $defaultlessProperty;
    protected static $defaultName;
}
// phpcs:enable
