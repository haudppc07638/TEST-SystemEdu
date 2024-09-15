<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;


class AdminMiddleware
{
    // public function handle(Request $request, Closure $next)
    // { 
    //     // if($request->routeIs('auth.google.employee')){
    //     //     if(Auth::guard('employee')->check()){
    //     //         return redirect()->route('admin.dashboard');
    //     //     }
    //     //     else{
    //     //         return $next($request);
    //     //     }      
    //     // }
    //     // if(!Auth::guard('employee')->check()){
    //     //     return redirect()->route('auth.employee');
    //     // }
    //     return $next($request);
    // }
    public function handle(Request $request, Closure $next): Response
{
        return $next($request);
}
}
