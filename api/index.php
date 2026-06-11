<?php

// Paksa bersihkan config cache biar Vercel baca .env yang baru
if (isset($_GET['clear-cache'])) {
    require __DIR__ . '/../bootstrap/app.php';
    echo "Memperbarui konfigurasi...<br>";
    Illuminate\Support\Facades\Artisan::call('config:clear');
    Illuminate\Support\Facades\Artisan::call('view:clear');
    Illuminate\Support\Facades\Artisan::call('route:clear');
    die("Cache Laravel berhasil dibersihkan! Silakan buka halaman utama tanpa tambahan teks di URL.");
}

require __DIR__ . '/../public/index.php';