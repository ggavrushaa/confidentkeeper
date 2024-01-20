<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LimitWarning extends Notification
{
    use Queueable;
    protected $category;
    public function __construct($category)
    {
        $this->category = $category;
    }

    public function toDatabase($notifiable) 
    {
        return  [
            'category_name' => $this->category->name,
            'limit' => $this->category->limit,
            'remaining' => $this->category->limit * 0.1,
        ];
    }


    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
