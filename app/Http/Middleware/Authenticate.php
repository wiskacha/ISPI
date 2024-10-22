<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Authenticate
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        dd(Auth::user());

        // if (Auth::check()) {
        //     // Allow access but check if the email is verified
        //     if (!Auth::user()->hasVerifiedEmail() && $request->route()->getName() !== 'verification.notice') {
        //         return redirect()->route('verification.notice')
        //             ->with('error', 'Please verify your email before accessing certain features.');
        //     }

        //     return $next($request);
        // }

        // return redirect()->route('/');
    }
}
