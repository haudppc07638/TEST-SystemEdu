<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'enrollments'], 
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:5500'], 
    'allowed_headers' => ['Content-Type', 'X-CSRF-TOKEN', 'Authorization'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,  
];

