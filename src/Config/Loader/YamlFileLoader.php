<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\UmlWriter\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

use InvalidArgumentException;
use function in_array;
use function is_array;
use function is_string;
use function pathinfo;
use function sprintf;
use const PATHINFO_EXTENSION;

/**
 * @author Laurent Laville
 */
final class YamlFileLoader extends FileLoader
{
    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function load(mixed $resource, ?string $type = null): array
    {
        try {
            $configs = Yaml::parseFile($resource, Yaml::PARSE_CONSTANT);
        } catch (ParseException $e) {
            throw new InvalidArgumentException(
                sprintf('The file "%s" does not contain valid YAML: ', $resource) . $e->getMessage(),
                0,
                $e
            );
        }

        if (null !== $configs && !is_array($configs)) {
            throw new InvalidArgumentException(sprintf('Unable to load file "%s".', $resource));
        }

        return $configs ?? [];
    }

    /**
     * @inheritDoc
     */
    public function supports($resource, ?string $type = null): bool
    {
        return is_string($resource)
            && in_array(pathinfo($resource, PATHINFO_EXTENSION), ['yml', 'yaml']);
    }
}
