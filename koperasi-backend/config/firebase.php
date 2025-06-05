<?php

declare(strict_types=1);

return [
    /*
     * ------------------------------------------------------------------------
     * Default Firebase project
     * ------------------------------------------------------------------------
     */

    'default' => env('FIREBASE_PROJECT', 'app'),

    /*
     * ------------------------------------------------------------------------
     * Firebase project configurations
     * ------------------------------------------------------------------------
     */

    'projects' => [
        'app' => [
            'credentials' => [
                'file' => env('FIREBASE_CREDENTIALS', storage_path('firebase-credentials.json')),
            ],
            'database' => [
                'url' => env('FIREBASE_DATABASE_URL', ''),
            ],
            'storage' => [
                'default_bucket' => env('FIREBASE_STORAGE_BUCKET', ''),
            ],
            'auth' => [
                'tenant_id' => env('FIREBASE_AUTH_TENANT_ID'),
            ],
            'cache_store' => env('FIREBASE_CACHE_STORE', 'file'),
            'logging' => [
                'http_log_channel' => env('FIREBASE_HTTP_LOG_CHANNEL', 'stack'),
                'http_debug_log_channel' => env('FIREBASE_HTTP_DEBUG_LOG_CHANNEL', 'stack'),
            ],
            'project_id' => env('FIREBASE_PROJECT_ID', ''),
            'messaging_sender_id' => env('FIREBASE_MESSAGING_SENDER_ID', ''),
            'app_id' => env('FIREBASE_APP_ID', ''),
            'measurement_id' => env('FIREBASE_MEASUREMENT_ID', ''),
        ],
    ],
]; 