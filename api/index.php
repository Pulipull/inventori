<?php

// Tampilkan semua error ke output
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Tangkap exception apa pun
set_exception_handler(function($e) {
    http_response_code(500);
    echo "<h1>Exception caught:</h1>";
    echo "<pre>" . $e->getMessage() . "\n" . $e->getTraceAsString() . "</pre>";
    exit;
});

$rootPath = dirname(__DIR__);

// Cek file penting
if (!file_exists($rootPath . '/public/index.php')) {
    die("ERROR: public/index.php not found at " . $rootPath . '/public/index.php');
}
if (!file_exists($rootPath . '/bootstrap/app.php')) {
    die("ERROR: bootstrap/app.php not found");
}
if (!file_exists($rootPath . '/vendor/autoload.php')) {
    die("ERROR: vendor/autoload.php not found. Run 'composer install'.");
}

// Cek .env (tidak wajib, tapi informatif)
$envFile = $rootPath . '/.env';
if (!file_exists($envFile)) {
    echo "WARNING: .env file not found. Make sure environment variables are set in Vercel.<br>";
}

require $rootPath . '/vendor/autoload.php';

$app = require $rootPath . '/bootstrap/app.php';

// Override beberapa config penting untuk serverless
$app->useStoragePath('/tmp/storage');
$app->make('config')->set('session.driver', 'array');
$app->make('config')->set('cache.default', 'array');
$app->make('config')->set('view.compiled', '/tmp/views');

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();
$kernel->terminate($request, $response);