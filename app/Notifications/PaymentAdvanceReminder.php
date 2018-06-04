<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use DB;

class PaymentAdvanceReminder extends Notification
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
        ->subject($appName.' - Huurbetaling')
        ->line('Over 3 weken staat uw verblijf ingepland in de '.$location->location_name.' te '.$location->location_location.'.')
        ->line('Wij willen u er aan herinneren dat wij uw huurbetaling nog niet hebben ontvangen, deze dient conform onze voorwaarden maximaal 14 dagen voor vertrek bij ons binnen te zijn.')
        ->line('Na uw betaling kunt u pas de sleutel voor het door u gehuurde huisje in ontvangst nemen.')
        ->line('Wij verzoeken u vriendelijk deze betaling per omgaande te doen door onderstaande knop te gebruiken.')
        ->action('Inloggen & Betalen', $url)
        ->line('Het is niet mogelijk de huurbetaling op andere wijze te doen.')
        ->line('Wij hopen u hierbij voldoende te hebben ingelicht.')
        ->line('Wij zullen u op de hoogte houden door middel van een email van eventuele status wijzigingen op uw account.')
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
