<?php

use React\EventLoop\Factory;
use Clue\React\Bitbake\Launcher;

require __DIR__ . '/../vendor/autoload.php';

$hostname = isset($argv[1]) ? $argv[1] : 'build.local';
$package = isset($argv[2]) ? $argv[2] : 'linux';
$path = '~/workspace/bitbake';

$loop = Factory::create();
$launcher = new Launcher($loop);
$launcher->setBinSsh($hostname, $path);
$shell = $launcher->launchInteractiveShell();

function e(Exception $e)
{
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}

$shell->peek($package, 'PV')->then(function ($val) { echo 'Original PV: ' . $val . PHP_EOL ; }, 'e');
$shell->poke($package, 'PV', '2.0')->then(function ($val) { echo 'Changed PV: ' . $val . PHP_EOL ; }, 'e');
$shell->peek($package, 'PV')->then(function ($val) { echo 'Current PV: ' . $val . PHP_EOL ; }, 'e');

$shell->end();

$loop->run();
