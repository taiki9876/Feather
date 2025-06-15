<?php

return [
    'name' => 'Mini Framework',
    'env' => $_ENV['APP_ENV'] ?? 'production',
    'debug' => $_ENV['APP_DEBUG'] ?? false,
    'url' => $_ENV['APP_URL'] ?? 'http://localhost:8000',
    'view' => [
        'path' => __DIR__ . '/../views',
    ],
    'session' => [
        'driver' => $_ENV['SESSION_DRIVER'] ?? 'file',
        'lifetime' => $_ENV['SESSION_LIFETIME'] ?? 120,
    ],
]; 