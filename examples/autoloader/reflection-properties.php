<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Laurent Laville
 */

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
