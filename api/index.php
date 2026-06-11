<?php

// 1. OTOMATIS EKSTRAK VENDOR.ZIP (PENTING!)
if (!file_exists(__DIR__ . '/../vendor/autoload.php') && file_exists(__DIR__ . '/../vendor.zip')) {
    $zip = new ZipArchive;
    if ($zip->open(__DIR__ . '/../vendor.zip') === TRUE) {
        $zip->extractTo(__DIR__ . '/../');
        $zip->close();
    }
}

// 2. MENGALIHKAN PATH CACHE KE /tmp
$_ENV['VIEW_COMPILED_PATH'] = '/tmp';
putenv('VIEW_COMPILED_PATH=/tmp');

// 3. Fitur Clear Cache
if (isset($_GET['clear-cache'])) {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->call('config:clear');
    $kernel->call('view:clear');
    $kernel->call('route:clear');
    die("Cache dibersihkan!");
}

// 4. Jalankan Laravel
require __DIR__ . '/../public/index.php';