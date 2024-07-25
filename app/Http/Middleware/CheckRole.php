<?php

// app/Http/Middleware/CheckRole.php

// app/Http/Middleware/CheckRole.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class CheckRole
{

    public function handle(Request $request, Closure $next, $role)
    {

        $user = Auth::user();

        if ($user && $user->hasRole($role)) {
            return $next($request);
        }

        return redirect('/dashboard')->withErrors('You do not have the required role.');
    }
}
