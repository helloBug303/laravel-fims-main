<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user() || auth()->user()->user_level !== 'admin') {
            return redirect('/');  // Redirect to home if not admin
        }
        return $next($request);
    }
}


