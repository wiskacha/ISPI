<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;

    protected $token;
    protected $user;

    public function __construct($token, $user)
    {
        $this->token = $token;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('password/reset/' . $this->token);

        // Podemos usar el nick o name, dependiendo de tu modelo de usuario
        $userName = $this->user->nick ?? $this->user->name;

        return (new MailMessage)
            ->subject('Restablecer Contraseña')
            ->greeting('¡Hola, ' . $userName . '!')
            ->line('Recibimos una solicitud para restablecer la contraseña de tu cuenta.')
            ->action('Restablecer Contraseña', $url)
            ->line('Si no solicitaste un restablecimiento de contraseña, no es necesario que tomes ninguna acción.')
            ->line('Este enlace expirará en ' . config('auth.passwords.users.expire') . ' minutos.')
            ->salutation('Gracias, El equipo de ' . config('app.name'));
    }
}
