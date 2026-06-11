<?php

$rootPath = dirname(__DIR__);

require $rootPath . '/vendor/autoload.php';

// Set environment variables SEBELUM bootstrap (agar driver yang butuh write tidak digunakan)
putenv('SESSION_DRIVER=array');
putenv('CACHE_STORE=array');
putenv('LOG_CHANNEL=stderr');
putenv('VIEW_COMPILED_PATH=/tmp');
putenv('QUEUE_CONNECTION=sync');

$_ENV['SESSION_DRIVER'] = 'array';
$_ENV['CACHE_STORE'] = 'array';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp';
$_ENV['QUEUE_CONNECTION'] = 'sync';

$app = require $rootPath . '/bootstrap/app.php';

// Ganti storage path ke /tmp (writable di Vercel)
$app->useStoragePath('/tmp');

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();
$kernel->terminate($request, $response);