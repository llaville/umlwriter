<?php

namespace Name\Space;

use Bartlett\GraphUml\Formatter\FormatterInterface;
use Bartlett\GraphUml\Formatter\HtmlFormatter;
use Bartlett\GraphUml\Generator\AbstractGenerator;
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
        return 'TODO: Implement createScript() method.' . PHP_EOL;
    }
}
