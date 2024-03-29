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
use Symfony\Component\OptionsResolver\OptionsResolver;

use InvalidArgumentException;
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
    private ?string $filename;
    /** @var array<string, mixed>  */
    private array $configStore;
    private bool $initialized;
    private OptionsResolver $optionsResolver;

    public function __construct(?string $filename = null)
    {
        $this->filename = $filename;
        $this->initialized = false;

        $this->optionsResolver = new OptionsResolver();
        $this->optionsResolver->setDefaults(self::getDefaults());
    }

    /**
     * @return array<string, mixed>
     */
    public static function getDefaults(): array
    {
        return [
            'generator' => 'graphviz',
            'graph' => [
                'name' => 'G',
                'overlap' => 'false',
                'rankdir' => 'TB',
                'bgcolor' => 'transparent',
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
            'paths' => [],
            'label_format' => 'html',
            'show_constants' => ClassDiagramBuilderInterface::OPTIONS_DEFAULTS['show_constants'],
            'show_properties' => ClassDiagramBuilderInterface::OPTIONS_DEFAULTS['show_properties'],
            'show_methods' => ClassDiagramBuilderInterface::OPTIONS_DEFAULTS['show_methods'],
            'show_private' => ClassDiagramBuilderInterface::OPTIONS_DEFAULTS['show_private'],
            'show_protected' => ClassDiagramBuilderInterface::OPTIONS_DEFAULTS['show_protected'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        if (!$this->initialized) {
            $this->initialize();
        }
        return $this->configStore;
    }

    /**
     * @return array<string, mixed>
     */
    public function toFlat(): array
    {
        if (!$this->initialized) {
            $this->initialize();
        }
        return $this->flatten($this->configStore);
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
                $options = $configs['parameters'];
            } catch (FileLocatorFileNotFoundException $exception) {
                throw new InvalidArgumentException($exception->getMessage(), 0, $exception);
            }
        } else {
            $options = [];
        }
        $this->configStore = $this->optionsResolver->resolve($options);
        $this->initialized = true;
    }

    /**
     * Flattens a nested array of configurations.
     *
     * The scheme used is:
     *   'key' => ['key2' => ['key3' => 'value']]
     * Becomes:
     *   'key.key2.key3' => 'value'
     *
     * @see https://github.com/symfony/translation/blob/master/Loader/ArrayLoader.php
     * @param array<string, mixed> $configs
     * @return array<string, mixed>
     */
    private function flatten(array $configs): array
    {
        $result = [];
        foreach ($configs as $key => $value) {
            if (is_array($value)) {
                foreach ($this->flatten($value) as $k => $v) {
                    $result[$key . '.' . $k] = $v;
                }
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}
