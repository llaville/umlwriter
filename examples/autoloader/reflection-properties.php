<?php

namespace Name\Space;

class Bar
{
    protected $inheritedProperty = 'inheritedDefault';
}

class Foo extends Bar
{
    public $property = 'propertyDefault';
    private $privateProperty = 'privatePropertyDefault';
    public static $staticProperty = 'staticProperty';
    public $defaultlessProperty;
    protected static $defaultName;
}
