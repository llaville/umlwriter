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

$bootstrap = require __DIR__ . '/bootstrap.php';
$bootstrap();

use Bartlett\UmlWriter\Console\Application;
use Bartlett\UmlWriter\Service\ContainerService;
use Bartlett\UmlWriter\Generator\GeneratorFactoryInterface;
use Name\Space\MyGeneratorFactory;

$container = new ContainerService();
$container->set(GeneratorFactoryInterface::class, fn() => new MyGeneratorFactory());

$application = new Application($container);
$application->run();
