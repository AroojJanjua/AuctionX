<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailOtp extends Notification
{
    use Queueable;
    public function __construct(private readonly string $code)
    {
    }

    public function via($notifiable): array{
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage{
        return (new MailMessage)
            ->subject('One Time PIN (OTP) for Email Verification')
            ->greeting('Dear '.$notifiable->name.',')
            ->line('We received a request to generate a One Time PIN to verify your email address. Please enter the following One Time PIN.')
            ->line('Your authentication code is '.$this->code)
            ->line('This code expires in 10 minutes. Kindly do not share your OTP with others for your own security.')
            ->salutation('Thank you');
    }
}