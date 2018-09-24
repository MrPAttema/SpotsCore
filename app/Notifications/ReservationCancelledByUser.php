<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationCancelled extends Notification
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
        $url = url('https://mijn.belboeivlieland.nl/login');
        return (new MailMessage)    
            ->greeting('Geachte mevr. / mijnheer.')
            ->subject($appName.' - Uw reservering status')
            ->line('Wij hebben uw verzoek tot annulering ontvangen.')
            ->line('Via deze email stellen wij u op de hoogte dat de status van uw reservering met reserveringnummer #'.$reservationID.' is veranderd naar "geannuleerd".')
            ->action('Bekijk de status hier', $url)
            ->line('Wij hopen u graag nogmaals te zien.')
            ->line('Wij zullen u op de hoogte houden door middel van een email van status wijzigingen op uw account.')
            ->line('Deze email is automatisch verstuurd, u kunt hier niet op reageren.')
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
