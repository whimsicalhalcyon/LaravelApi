<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Здесь мы указываем, какие источники могут делать запросы к API.
    |
    */

    'paths' => ['messages', 'api/*'], // маршруты, где разрешён CORS
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:5173'], // где запущен Vue dev server
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,

];
