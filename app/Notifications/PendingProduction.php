<?php

namespace App\Notifications;

use App\Production;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PendingProduction extends Notification
{
    use Queueable;
    public $productionInformation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Production $productionInformation)
    {
        $this->productionInformation = $productionInformation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'id'    => $this->productionInformation->id,
            'name'  => $this->productionInformation->name,
            'status'=> $this->productionInformation->status,
            'code'  => $this->productionInformation->production_code,
        ];
    }
}
