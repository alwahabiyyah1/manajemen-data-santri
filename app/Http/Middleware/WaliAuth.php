<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('wali')->check()) {
            return redirect()->route('wali.login');
        }
        return $next($request);
    }
}
