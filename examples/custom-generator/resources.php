<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Laurent Laville
 * @since Release 4.0.0
 */

namespace Name\Space;

use Bartlett\GraphUml\Formatter\FormatterInterface;
use Bartlett\GraphUml\Formatter\HtmlFormatter;
use Bartlett\GraphUml\Generator\AbstractGenerator;
use Bartlett\UmlWriter\Generator\GeneratorFactory;
use Bartlett\GraphUml\Generator\GeneratorInterface;

use Graphp\Graph\Graph;

class MyGenerator extends AbstractGenerator implements GeneratorInterface
{
    public function getFormatter(): FormatterInterface
    {
        return new HtmlFormatter($this->options);
    }

    public function getName(): string
    {
        return 'mygenerator';
    }

    public function createScript(Graph $graph): string
    {
        return 'TODO: Implement createScript() method.';
    }

    public function createImageFile(Graph $graph, string $cmdFormat): string
    {
        return '/image_generation_not_implemented';
    }
}

class MyGeneratorFactory extends GeneratorFactory
{
    public function createInstance(string $provider, string $format = 'svg', string $executable = ''): GeneratorInterface
    {
        if ('mygenerator' === $provider) {
            return new MyGenerator($executable, $format);
        }
        // fallback to default GeneratorFactory behavior (checks for GraphViz or PlantUML)
        parent::createInstance($provider, $format, $executable);
    }
}
