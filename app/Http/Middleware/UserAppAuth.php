<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class UserAppAuth
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('app_user_id')) {
            return redirect()->route('userLogin.app')->with('error', 'Please log in first.');
        }

        return $next($request);
    }
}
