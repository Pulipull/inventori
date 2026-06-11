<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$rootPath = dirname(__DIR__);

// Cek file penting (opsional, untuk debugging)
if (!file_exists($rootPath . '/vendor/autoload.php')) {
    die('Vendor autoload not found. Run composer install.');
}
if (!file_exists($rootPath . '/bootstrap/app.php')) {
    die('Bootstrap app not found.');
}

require $rootPath . '/vendor/autoload.php';
$app = require $rootPath . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();
$kernel->terminate($request, $response);