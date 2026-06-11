<?php

// Paksa PHP untuk menampilkan error ke layar agar kita bisa melihatnya
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Tentukan path root proyek
$rootPath = dirname(__DIR__);

// Debugging: Cek apakah file utama ada
if (!file_exists($rootPath . '/public/index.php')) {
    die("Gagal: public/index.php tidak ditemukan di " . $rootPath . '/public/index.php');
}

if (!file_exists($rootPath . '/vendor/autoload.php')) {
    die("Gagal: vendor/autoload.php tidak ditemukan di " . $rootPath . '/vendor/autoload.php');
}

// Jalankan Laravel
require_once $rootPath . '/vendor/autoload.php';
$app = require_once $rootPath . '/bootstrap/app.php';

// Pindahkan proses ke Kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();
$kernel->terminate($request, $response);