<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordFoodTY extends Notification
{
    use Queueable;

    public function __construct(public string $token) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Reset Password • FoodTY')
            // ini yang bikin kita pakai template HTML sendiri (lebih cakep)
            ->view('emails.reset-password-foodty', [
                'url' => $url,
                'name' => $notifiable->name ?? 'Sobat FoodTY',
                'expire' => 60,
            ]);
    }
}
