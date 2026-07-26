<?php

declare(strict_types=1);

use App\Support\Env;

return [
    'app' => [
        'name' => 'MiniILIAS Learning Portal',
        'env' => Env::get('APP_ENV', 'local'),
        'debug' => Env::bool('APP_DEBUG', true),
        'url' => Env::get('APP_URL', 'http://localhost:8000'),
    ],
    'db' => [
        'host' => Env::get('DB_HOST', '127.0.0.1'),
        'port' => Env::int('DB_PORT', 3306),
        'database' => Env::get('DB_DATABASE', 'mini_ilias'),
        'username' => Env::get('DB_USERNAME', 'root'),
        'password' => Env::get('DB_PASSWORD', ''),
        'charset' => 'utf8mb4',
    ],
    'logging' => [
        'path' => dirname(__DIR__) . '/storage/logs/app.log',
    ],
];
