<?php

return [
    'access_token_ttl' => (int) env('AUTH_ACCESS_TOKEN_TTL', 15),
    'refresh_token_ttl' => (int) env('AUTH_REFRESH_TOKEN_TTL', 1440),
    'refresh_token_ttl_remember' => (int) env('AUTH_REFRESH_TOKEN_TTL_REMEMBER', 43200),
    'idle_timeout_minutes' => (int) env('AUTH_IDLE_TIMEOUT_MINUTES', 90),
    'refresh_cookie_name' => 'archetype_refresh',
    'cookie_secure' => !in_array(env('APP_ENV'), ['local', 'testing'], true),
    'cookie_same_site' => 'lax',
    'frontend_url' => env('FRONTEND_URL', env('APP_URL', 'http://localhost')),
];
