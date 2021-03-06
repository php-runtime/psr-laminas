<?php

use Symfony\Component\Runtime\SymfonyRuntime;

$_SERVER['APP_RUNTIME_OPTIONS'] = [
    'project_dir' => __DIR__,
];

if (file_exists(dirname(__DIR__, 2).'/vendor/autoload.php')) {
    if (true === (require_once dirname(__DIR__, 2).'/vendor/autoload.php') || empty($_SERVER['SCRIPT_FILENAME'])) {
        return;
    }

    $app = require $_SERVER['SCRIPT_FILENAME'];
    $runtimeClass = $_SERVER['APP_RUNTIME'] ?? SymfonyRuntime::class;
    $runtime = new $runtimeClass($_SERVER['APP_RUNTIME_OPTIONS']);
    [$app, $args] = $runtime->getResolver($app)->resolve();
    exit($runtime->getRunner($app(...$args))->run());
}

if (!file_exists(dirname(__DIR__, 4).'/vendor/autoload_runtime.php')) {
    throw new LogicException('Autoloader not found.');
}

require dirname(__DIR__, 4).'/vendor/autoload_runtime.php';
