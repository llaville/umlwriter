<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @since Release 3.0.0
 * @author Laurent Laville
 */

use Bartlett\GraphUml\Filter\NamespaceFilterInterface;

$namespaceFilter = new class() implements NamespaceFilterInterface
{
    private ?string $shortClass;

    public function filter(string $fqcn): ?string
    {
        $nameParts = explode('\\', $fqcn);
        $this->shortClass = array_pop($nameParts);  // removes short name part of Fully Qualified Class Name

        return implode('\\', $nameParts);
    }

    public function getShortClass(): ?string
    {
        return $this->shortClass;
    }
};
