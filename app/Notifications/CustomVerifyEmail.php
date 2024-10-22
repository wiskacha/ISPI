<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        
        // Obtener el nombre del usuario del modelo notifiable (usuario)
        $userName = $notifiable->name ?? $notifiable->nick ?? 'Usuario';
        
        return (new MailMessage)
            ->subject('Verifica tu cuenta en ' . config('app.name'))
            ->markdown('emails.verify-email', [
                'url' => $verificationUrl,
                'userName' => $userName // Pasamos el nombre a la vista
            ]);
    }
}