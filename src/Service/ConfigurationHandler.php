<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\UmlWriter\Service;

use Bartlett\GraphUml\ClassDiagramBuilderInterface;
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

/**
 * @author Laurent Laville
 */
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
            'generator' => 'graphviz',
            'graph' => [
                'name' => 'G',
                'overlap' => 'false',
                'rankdir' => 'TB',
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
            'cluster' => null,
            'paths' => [
                'src',
            ],
            'show_constants' => ClassDiagramBuilderInterface::OPTIONS_DEFAULTS['show_constants'],
            'show_properties' => ClassDiagramBuilderInterface::OPTIONS_DEFAULTS['show_properties'],
            'show_methods' => ClassDiagramBuilderInterface::OPTIONS_DEFAULTS['show_methods'],
            'show_private' => ClassDiagramBuilderInterface::OPTIONS_DEFAULTS['show_private'],
            'show_protected' => ClassDiagramBuilderInterface::OPTIONS_DEFAULTS['show_protected'],
        ];

        $this->optionsResolver = new OptionsResolver();
        $this->optionsResolver->setDefaults($defaults);
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
                $configs = $loader->load($this->filename);
                $this->configStore = $this->optionsResolver->resolve($configs['parameters']);
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
