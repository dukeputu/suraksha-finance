<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class MemberAuth
{
    public function handle($request, Closure $next)
    {
        // Check if user is logged in using session (adjust as needed)
        if (!Session::has('member_id')) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        return $next($request);
    }
}




