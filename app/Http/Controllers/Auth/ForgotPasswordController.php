<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Notifications\PasswordResetNotification;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validación del correo electrónico
        $this->validateEmail($request);

        // Buscar al usuario por email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Generar el token
            $token = Password::createToken($user);

            // Enviar la notificación personalizada
            $user->notify(new PasswordResetNotification($token, $user));

            return back()->with('status', '¡Hemos enviado un enlace de restablecimiento a tu correo electrónico!');
        }

        return back()->withErrors(['email' => 'No se pudo enviar el enlace de restablecimiento. Por favor, verifica tu correo electrónico.']);
    }

    protected function validateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'El campo de correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.exists' => 'Este correo electrónico no está registrado en nuestro sistema.',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
