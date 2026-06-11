<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// ========== TAMBAHKAN INI UNTUK VERCEL ==========
$app->useStoragePath('/tmp');
$_ENV['SESSION_DRIVER'] = 'array';
$_ENV['CACHE_STORE'] = 'array';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp';
$_ENV['QUEUE_CONNECTION'] = 'sync';
putenv('SESSION_DRIVER=array');
putenv('CACHE_STORE=array');
putenv('LOG_CHANNEL=stderr');
putenv('VIEW_COMPILED_PATH=/tmp');
putenv('QUEUE_CONNECTION=sync');
// ================================================

$app->handleRequest(Request::capture());