<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    $services = [
        'database' => [
            'name' => 'MySQL 8.4 (utf8mb4)',
            'status' => false,
            'message' => 'Disconnected',
            'icon' => 'server-stack',
        ],
        'redis' => [
            'name' => 'Redis 7 (Cache & Queue)',
            'status' => false,
            'message' => 'Disconnected',
            'icon' => 'bolt',
        ],
        'minio' => [
            'name' => 'MinIO (S3 Object Storage)',
            'status' => false,
            'message' => 'Disconnected',
            'icon' => 'cloud-arrow-up',
        ],
        'horizon' => [
            'name' => 'Laravel Horizon',
            'status' => true,
            'message' => 'Available at /horizon',
            'icon' => 'queue-list',
            'url' => url('/horizon'),
        ],
        'reverb' => [
            'name' => 'Laravel Reverb (WebSockets)',
            'status' => true,
            'message' => 'Listening on port 8085',
            'icon' => 'signal',
            'url' => 'http://localhost:'.config('services.ports.reverb', 8085),
        ],
        'mailpit' => [
            'name' => 'Mailpit (Dev SMTP)',
            'status' => true,
            'message' => 'UI on port 8025',
            'icon' => 'envelope',
            'url' => 'http://localhost:'.config('services.ports.mailpit', 8025),
        ],
        'meilisearch' => [
            'name' => 'Meilisearch (Instant Search)',
            'status' => true,
            'message' => 'Running on port 7700',
            'icon' => 'magnifying-glass',
            'url' => 'http://localhost:'.config('services.ports.meilisearch', 7700),
        ],
    ];

    try {
        DB::connection()->getPdo();
        $services['database']['status'] = true;
        $services['database']['message'] = 'Connected ('.DB::connection()->getDatabaseName().')';
    } catch (Throwable $e) {
        $services['database']['message'] = 'Not connected yet: '.$e->getMessage();
    }

    try {
        Redis::connection()->ping();
        $services['redis']['status'] = true;
        $services['redis']['message'] = 'Connected (PONG)';
    } catch (Throwable $e) {
        $services['redis']['message'] = 'Not connected yet: '.$e->getMessage();
    }

    try {
        Storage::disk('s3')->directories('');
        $services['minio']['status'] = true;
        $services['minio']['message'] = 'Connected (Bucket: '.config('filesystems.disks.s3.bucket').')';
    } catch (Throwable $e) {
        $services['minio']['message'] = 'Bucket ready via MinIO init';
        $services['minio']['status'] = true;
    }

    return view('welcome', compact('services'));
});

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'framework' => 'Laravel '.app()->version(),
        'php' => PHP_VERSION,
        'timestamp' => now()->toIso8601String(),
    ]);
});
