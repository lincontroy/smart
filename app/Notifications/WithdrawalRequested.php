<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalRequested extends Notification
{
    use Queueable;

    protected $withdrawal;

    public function __construct($withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Withdrawal Request Received')
            ->line('Your withdrawal request of $' . $this->withdrawal->amount . ' has been received.')
            ->line('Method: ' . ucfirst($this->withdrawal->method))
            ->line('Status: Pending')
            ->action('View Dashboard', url('/dashboard'))
            ->line('Thank you for using our service!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Withdrawal request of $' . $this->withdrawal->amount . ' submitted',
            'url' => '/withdrawals/' . $this->withdrawal->id
        ];
    }
}