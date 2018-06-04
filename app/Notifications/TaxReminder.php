<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use DB;

class TaxReminder extends Notification
{
    use Queueable;
    
    protected $reservation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
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
        $reservationID = $this->reservation->id;
        $locations = DB::table('locations')->where('id', $this->reservation->location_id)->get();
        foreach ($locations as $location) {
            
        }
        $url = url('/reservations/myreservations');
        return (new MailMessage)
            ->greeting('Geachte mevr. / mijnheer.')
            ->subject($appName.' - Betaling toeristenbelasting')
            ->line('Wij hopen dat u een aangenaam verblijf heeft gehad in de '.$location->location_name.'.')
            ->line('Voor verblijf in de '.$location->location_name.' is per overnachting toeristenbelasting verschuldigd. Wij vragen u vriendelijk de opgave en betaling hiervan te doen binnen 14 dagen na terugkomst.')
            ->line('U kunt de opgave en betaling doen door op de knop hieronder te gebruiken.')
            ->action('Opgeven & Betalen', $url)
            ->line('Het is niet mogelijk de opgave voor de toeristenbelasting op andere wijze te doen.')
            ->line('Vertrouwende u hierbij voldoende te hebben ingelicht.')
            ->line('Wij zullen u op de hoogte houden door middel van een email van status wijzigingen op uw account.')
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
