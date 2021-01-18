<?php

namespace App\Notifications;

use App\EmailBounce;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use function route;

class EmailBounced extends Notification
{
    use Queueable;

    public $bounce;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(EmailBounce $bounce)
    {
        $this->bounce = $bounce;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->subject('Er is een bounce in postmark!')
                    ->line('Er is een bounce geweest in postmark!')
                    ->action('Bekijk welke e-mail', route('email.bounces.message', [$this->bounce]));
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
