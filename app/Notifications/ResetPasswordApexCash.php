<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordApexCash extends ResetPassword
{
    public function toMail($notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Restablecer contraseña - ApexCash')
            ->view('emails.reset-password', [
                'url' => $url,
                'user' => $notifiable,
                'expire' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire'),
            ]);
    }
}