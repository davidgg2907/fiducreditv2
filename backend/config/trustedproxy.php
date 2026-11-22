<?php

return [
    'proxies' => array_values(array_filter(
        array_map('trim', explode(',', (string) env('TRUSTED_PROXIES', ''))),
        static fn (string $proxy) => $proxy !== '' && !str_contains($proxy, '*'),
    )),
];
