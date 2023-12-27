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

use Bartlett\GraphUml\ClassDiagramBuilder;
use Bartlett\GraphUml\Formatter\AbstractFormatter;
use Bartlett\GraphUml\Formatter\FormatterInterface;
use Bartlett\GraphUml\Formatter\HtmlFormatter;
use Bartlett\GraphUml\Formatter\RecordFormatter;

return function (): Generator {
    $classes = [
        AbstractFormatter::class,
        FormatterInterface::class,
        HtmlFormatter::class,
        RecordFormatter::class,
        ClassDiagramBuilder::class,
    ];
    foreach ($classes as $class) {
        yield $class;
    }
};
