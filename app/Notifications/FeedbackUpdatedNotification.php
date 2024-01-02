<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FeedbackUpdatedNotification extends Notification
{
    use Queueable;
    protected $feedback;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function __construct($feedback)
    {
        $this->feedback = $feedback;
    }


    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your feedback has been updated.',
            'feedback_id' => $this->feedback->id,
        ];
    }

    public function via($notifiable)
    {
        return ['database']; // Specify 'database' as the delivery channel
    }
}
