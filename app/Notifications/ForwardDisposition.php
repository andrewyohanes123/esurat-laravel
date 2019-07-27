<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ForwardDisposition extends Notification
{
    use Queueable;
    public $from_user;
    public $to_user;
    public $disposition;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($from_user, $to_user, $disposition)
    {
        $this->from_user = $from_user;
        $this->to_user = $to_user;
        $this->disposition = $disposition;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase()
    {
        return [
            'from_user' => $this->from_user,
            'to_user' => $this->to_user,
            'type' => 1,
            'disposition' => $this->disposition
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
