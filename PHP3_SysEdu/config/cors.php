<?php

return [
    'paths' => ['api/*', 'enrollments'], 
    'allowed_methods' => ['*'], 
    'allowed_origins' => ['http://localhost:3000'], // Cấu hình domain mà bạn muốn cho phép
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, 
];
