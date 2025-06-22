<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailCustom extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        return (new MailMessage)
            ->subject('Подтвердите ваш email на AssitantLib')
            ->greeting('Добро пожаловать в AssitantLib!')
            ->line('Спасибо за регистрацию на нашем сайте.')
            ->line('Пожалуйста, подтвердите ваш email, чтобы завершить регистрацию и получить доступ ко всем функциям.')
            ->action('Подтвердить email', $verificationUrl)
            ->line('Если вы не регистрировались на нашем сайте, просто проигнорируйте это письмо.')
            ->salutation('С уважением, команда AssitantLib');
    }
} 