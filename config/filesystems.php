<?php

return [
    'default' => env('FILESYSTEM_DISK', 'local'),
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => false,
            'throw' => false,
        ],
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],
        'minio' => [
            'driver' => 's3',
            'key' => env('MINIO_ACCESS_KEY_ID'),
            'secret' => env('MINIO_SECRET_ACCESS_KEY'),
            'region' => env('MINIO_DEFAULT_REGION', 'us-east-1'),
            'bucket' => env('MINIO_BUCKET', 'inventori'),
            'url' => env('MINIO_URL'),
            'endpoint' => env('MINIO_ENDPOINT'),
            'use_path_style_endpoint' => env('MINIO_USE_PATH_STYLE_ENDPOINT', true),
            'throw' => false,
        ],
    ],
    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
];
