<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Impersonate
{
    public function handle($request, Closure $next)
    {
        if (session()->has('impersonate')) {
            $impersonatedUserId = session('impersonate');
            if (Auth::id() !== $impersonatedUserId) {
                Auth::loginUsingId($impersonatedUserId);
            }
        }

        return $next($request);
    }
}

