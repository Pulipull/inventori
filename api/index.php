<?php

// 1. OTOMATIS EKSTRAK VENDOR.ZIP
if (!file_exists(__DIR__ . '/../vendor/autoload.php') && file_exists(__DIR__ . '/../vendor.zip')) {
    $zip = new ZipArchive;
    if ($zip->open(__DIR__ . '/../vendor.zip') === TRUE) {
        $zip->extractTo(__DIR__ . '/../');
        $zip->close();
    }
}

// 2. MENGALIHKAN PATH CACHE, LOG, DAN SESSION KE /tmp
$_ENV['VIEW_COMPILED_PATH'] = '/tmp';
putenv('VIEW_COMPILED_PATH=/tmp');

$_ENV['LOG_CHANNEL'] = 'stderr'; // Paksa log ke system output Vercel (bukan ke file)
putenv('LOG_CHANNEL=stderr');

$_ENV['SESSION_DRIVER'] = 'array'; // Jangan simpan session ke file, simpan di memori
putenv('SESSION_DRIVER=array');

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
chdir(__DIR__ . '/..'); // Pindahkan "posisi berdiri" script ke root folder
require 'public/index.php';