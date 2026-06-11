<?php

$rootPath = dirname(__DIR__);
require $rootPath . '/vendor/autoload.php';

$app = require $rootPath . '/bootstrap/app.php';

// ========== WAJIB: Override storage ke /tmp ==========
$app->useStoragePath('/tmp');

// ========== Override semua driver yang perlu write ==========
$app->make('config')->set('session.driver', 'array');
$app->make('config')->set('cache.default', 'array');
$app->make('config')->set('view.compiled', '/tmp/views');
$app->make('config')->set('logging.default', 'stderr');
$app->make('config')->set('log.channels.stderr.driver', 'monolog');
$app->make('config')->set('log.channels.stderr.handler', Monolog\Handler\ErrorLogHandler::class);
$app->make('config')->set('queue.default', 'sync'); // nonaktifkan queue database

// Pastikan folder /tmp/views ada (opsional)
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}

// ========== Jalankan Laravel ==========
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();
$kernel->terminate($request, $response);