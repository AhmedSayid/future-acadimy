<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NotifyUser extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message, $user)
    {
        $this->title = $title;
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Determine which notification channels to use.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Define the database representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'title'     => $this->title,
            'message'   => $this->message,
            'user'      => $this->user,
//            'url' => '/notifications',
        ];
    }
}
