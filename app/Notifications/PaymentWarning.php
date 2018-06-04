<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentWarning extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $appName = config('app.name');
        $url = url('/reservations/myreservations');
        return (new MailMessage)
        ->greeting('Geachte mevr. / mijnheer.')
        ->subject($appName.' – Herinnering betaling toeristenbelasting')
        ->line('Wij willen u met deze email op de hoogste stellen dat u de opgave voor de toeristenbelasting nog moet doen.')
        ->line('In de voorwaarden van de huur staat aangegeven dat u uiterlijk 14 dagen na terugkomst de opgave en betaling van de toeristenbelasting dient te doen.')
        ->line('Wij attenderen u er op dat het betalingstermijn van 14 dagen is verstreken. Daarom vragen wij u de opgave alsnog per direct te doen door de knop hieronder te gebruiken.')
        ->action('Opgeven & Betalen', $url)
        ->line('Wij hopen u hierbij voldoende te hebben ingelicht.')
        ->line('Wij zullen u altijd op de hoogte houden door middel van een email van status wijzigingen op uw account.')
        ->success();
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
