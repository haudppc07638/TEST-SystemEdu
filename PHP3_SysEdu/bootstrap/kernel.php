<?php

namespace App\Http;

use App\Http\Middleware\HandleCors;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\CorsMiddleware::class,
    ];
    
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\CorsMiddleware::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            \App\Http\Middleware\CorsMiddleware::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
        ],
    ];
}
