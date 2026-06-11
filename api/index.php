<?php
// 1. Cek & Unzip vendor kalau belum ada
if (!file_exists(__DIR__ . '/../vendor/autoload.php') && file_exists(__DIR__ . '/../vendor.zip')) {
    $zip = new ZipArchive;
    if ($zip->open(__DIR__ . '/../vendor.zip') === TRUE) {
        $zip->extractTo(__DIR__ . '/../');
        $zip->close();
    }
}

// 2. Fitur Clear Cache
if (isset($_GET['clear-cache'])) {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->call('config:clear');
    $kernel->call('view:clear');
    $kernel->call('route:clear');
    die("Cache dibersihkan!");
}

// 3. Jalankan Laravel
require __DIR__ . '/../public/index.php';