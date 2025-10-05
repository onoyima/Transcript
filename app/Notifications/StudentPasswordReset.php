<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class StudentPasswordReset extends ResetPassword
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(route('student.password.reset.confirm', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Reset Your Password - Transcript System')
            ->greeting('Hello ' . $notifiable->firstname . ' ' . $notifiable->surname . '!')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->line('Please click the button below to reset your password.')
            ->action('Reset Password', $url)
            ->line('This password reset link will expire in 60 minutes.')
            ->line('If you did not request a password reset, no further action is required.')
            ->line('For security reasons, please do not share this link with anyone.')
            ->salutation('Best regards, Transcript System Team');
    }
}