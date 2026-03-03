<?php

/**
 * CORS config for SPA + Sanctum (cookie-based auth).
 *
 * IMPORTANT: keep origins in environment variables for deploys.
 */

return [
    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'login',
        'logout',
        'user',
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => (function (): array {
        $fromEnv = array_values(array_filter(array_map('trim', explode(',', (string) env('CORS_ALLOWED_ORIGINS', '')))));
        if (! empty($fromEnv)) {
            return $fromEnv;
        }

        return array_values(array_filter([
            env('FRONTEND_URL'),
            env('FRONTEND_URL_ALT'),
        ]));
    })(),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
