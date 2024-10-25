<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Importa el facade Auth
use Illuminate\Support\Facades\Hash; // Importa el facade Hash

class ResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        // Obtén el usuario a partir del token
        $user = User::where('email', request()->input('email'))->first();

        return view('auth.passwords.reset', [
            'token' => $token,
            'user' => $user // Pasar el usuario a la vista
        ]);
    }

    public function reset(Request $request)
    {
        // Asegúrate de que el usuario esté autenticado
        $user = User::where('email', $request->input('email'))->first(); // Asegúrate de obtener el usuario por email

        $messages = [
            'email.required' => 'El campo de correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico es inválido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos un número.',
            'password.not_current' => 'La nueva contraseña no puede ser igual a la contraseña actual.',
            'token.required' => 'El token de restablecimiento es obligatorio.',
        ];

        // Validación
        $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[0-9]/', // Debe contener al menos un número
                // Validación personalizada para no permitir la misma contraseña
                function ($attribute, $value, $fail) use ($user) {
                    if ($user && Hash::check($value, $user->password)) {
                        $fail(__('La nueva contraseña no puede ser igual a la contraseña actual.'));
                    }
                },
            ],
            'token' => 'required'
        ], $messages); // Agrega los mensajes personalizados aquí

        // Restablecimiento de la contraseña
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();

                // Inicia sesión al usuario después de cambiar la contraseña
                Auth::login($user);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('dashboard')->with('success', __('Contraseña cambiada satisfactoriamente.'))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
