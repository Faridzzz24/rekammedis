<?php

// ─── Vercel Serverless: prepare writable paths in /tmp ───

// 1. Create storage directories
foreach ([
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// 2. Copy SQLite database to /tmp (writable)
$dbSrc = __DIR__ . '/../database/database.sqlite';
if (file_exists($dbSrc) && !file_exists('/tmp/database.sqlite')) {
    copy($dbSrc, '/tmp/database.sqlite');
}

// 3. Set environment variables BEFORE Laravel boots.
//    putenv + $_ENV + $_SERVER ensures all config helpers pick them up.
$vars = [
    'APP_STORAGE_PATH'   => '/tmp/storage',
    'APP_SERVICES_CACHE' => '/tmp/bootstrap/cache/services.php',
    'APP_PACKAGES_CACHE' => '/tmp/bootstrap/cache/packages.php',
    'APP_CONFIG_CACHE'   => '/tmp/bootstrap/cache/config.php',
    'APP_ROUTES_CACHE'   => '/tmp/bootstrap/cache/routes.php',
    'APP_EVENTS_CACHE'   => '/tmp/bootstrap/cache/events.php',
    'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
    'LOG_CHANNEL'        => 'stderr',
    'LOG_STACK'          => 'stderr',
    'SESSION_DRIVER'     => 'cookie',
    'CACHE_STORE'        => 'array',
    'CACHE_DRIVER'       => 'array',
    'DB_CONNECTION'      => 'sqlite',
    'DB_DATABASE'        => '/tmp/database.sqlite',
];

foreach ($vars as $key => $val) {
    $_ENV[$key]    = $val;
    $_SERVER[$key] = $val;
    putenv("$key=$val");
}

// 4. Forward to Laravel
require __DIR__ . '/../public/index.php';
