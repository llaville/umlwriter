<?php

declare(strict_types=1);

namespace Bartlett\UmlWriter\Service;

use Bartlett\UmlWriter\Config\Loader\YamlFileLoader;

use Symfony\Component\Config\Exception\FileLocatorFileNotFoundException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;

use InvalidArgumentException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function array_key_exists;
use function basename;
use function dirname;
use function is_array;
use function realpath;

final class ConfigurationHandler
{
    /** @var string|null  */
    private $filename;

    /** @var array  */
    private $configStore;

    /** @var bool */
    private $initialized;

    /** @var OptionsResolver  */
    private $optionsResolver;

    public function __construct(?string $filename)
    {
        $this->filename = $filename;
        $this->initialized = false;

        $defaults = [
            'graph' => [
                'name' => 'G',
                'overlap' => 'false',
            ],
            'node' => [
                'fontname' => 'Verdana',
                'fontsize' => 8,
                'shape' => 'none',
                'margin' => 0,
                'fillcolor' => '#FEFECE',
                'style' => 'filled',
            ],
            'edge' => [
                'fontname' => 'Verdana',
                'fontsize' => 8,
            ],
            'colors' => [],
            'paths' => [],
        ];

        $this->optionsResolver = new OptionsResolver();
        $this->optionsResolver->setDefaults(['parameters' => $defaults]);
    }

    public function filename(): ?string
    {
        return $this->filename;
    }

    public function toArray(): array
    {
        if (!$this->initialized) {
            $this->initialize();
        }
        return $this->configStore;
    }

    public function toFlat(): array
    {
        if (!$this->initialized) {
            $this->initialize();
        }
        return $this->flatten($this->configStore);
    }

    public function getValueByKey(string $key, $default = null)
    {
        $data = $this->toFlat();
        return array_key_exists($key, $data) ? $data[$key] : $default;
    }

    private function initialize(): void
    {
        if (isset($this->filename)) {
            $paths = [realpath(dirname($this->filename))];
            $fileLocator = new FileLocator($paths);
            try {
                $resource = basename($this->filename);
                $this->filename = $fileLocator->locate($resource);
                $loaderResolver = new LoaderResolver([new YamlFileLoader($fileLocator)]);
                $loader = $loaderResolver->resolve($resource);
                $configs = $loader->load($resource);
                $this->configStore = $this->optionsResolver->resolve($configs);
            } catch (FileLocatorFileNotFoundException $exception) {
                throw new InvalidArgumentException($exception->getMessage(), 0, $exception);
            }
        } else {
            $this->configStore = $this->optionsResolver->resolve();
        }
        $this->initialized = true;
    }

    /**
     * Flattens an nested array of configurations.
     *
     * The scheme used is:
     *   'key' => ['key2' => ['key3' => 'value']]
     * Becomes:
     *   'key.key2.key3' => 'value'
     *
     * @see https://github.com/symfony/translation/blob/master/Loader/ArrayLoader.php
     * @param array $configs
     * @return array
     */
    private function flatten(array $configs): array
    {
        $result = [];
        foreach ($configs as $key => $value) {
            if (is_array($value)) {
                foreach ($this->flatten($value) as $k => $v) {
                    $result[$key.'.'.$k] = $v;
                }
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}
