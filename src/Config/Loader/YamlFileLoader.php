<?php

declare(strict_types=1);

namespace Bartlett\UmlWriter\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

use InvalidArgumentException;
use function is_array;
use function sprintf;

class YamlFileLoader extends FileLoader
{
    public function load($resource, string $type = null)
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

    public function supports($resource, string $type = null)
    {
        return is_string($resource)
            && in_array(pathinfo($resource, PATHINFO_EXTENSION), ['yml', 'yaml']);
    }
}
