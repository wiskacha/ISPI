<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class LoginController extends Controller
{
    public function show()
    {
        return view('landing');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        // Check if the user exists based on email or nickname
        $user = User::where('email', $credentials['email'] ?? null)
            ->orWhere('nick', $credentials['nick'] ?? null)
            ->first();

        if (!$user || !password_verify($credentials['password'], $user->password)) {
            Session::flash('error', 'Credenciales incorrectas');
            Session::flash('openModal', true);
            return redirect()->route('login')->withErrors('Error de inicio de sesión');
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
