<?php

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
    'allowed_origins' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('CORS_ALLOWED_ORIGINS', ''))
    ), fn (string $origin) => preg_match('~^https?://[^/*?#\\s]+$~i', $origin) === 1)),
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['Accept', 'Authorization', 'Content-Type', 'X-Auth-Request'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
