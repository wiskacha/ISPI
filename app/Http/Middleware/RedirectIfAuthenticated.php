<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    protected $guards = [];

    public function __construct()
    {
        $this->guards = array_keys(config('auth.guards'));
    }

    public function handle($request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect($this->redirectTo($guard));
            }
        }

        return $next($request);
    }

    protected function redirectTo($guard)
    {
        return config('auth.redirects.' . $guard, '/home');
    }
}
