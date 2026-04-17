<?php declare(strict_types=1);
/**
 * This file is part of the UmlWriter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Laurent Laville
 */

use Clue\GraphComposer\Command\Export;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

require_once dirname(__DIR__) . '/autoload.php';

$script = $_SERVER['argv'][1] ?? null;
$folder = $_SERVER['argv'][2] ?? sys_get_temp_dir();
$format = $_SERVER['argv'][3] ?? 'svg';

$graphComposer = dirname(__DIR__) . '/vendor-bin/graph-composer/vendor/autoload.php';
if ('graph-composer' == $script) {
    if (!file_exists($graphComposer)) {
        echo "[warning] Unable to produce Graph Composer: package 'bartlett/graph-composer' is not installed", PHP_EOL;
        exit(1);
    }

    $export = new Export('export');
    $target = $folder . '/graph-composer.svg';
    $input = new ArrayInput([
        'dir' => dirname(__DIR__),
        'output' => $target,
        '--depth' => 2,
        '--orientation' => 'LR',
    ]);
    $status = $export->run($input, new NullOutput());
    echo "[info] " . ($status != 0 ? 'no' : $target) . ' file generated' . PHP_EOL;
    exit($status);
}
