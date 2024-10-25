<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::middleware(['guest', 'throttle:60,1'])->group(function () {
    // Mostrar la vista del formulario de recuperación
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

    // Enviar el correo con el enlace para restablecer la contraseña
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Mostrar la vista para restablecer la contraseña
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

    // Procesar la solicitud de restablecimiento de contraseña
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});
