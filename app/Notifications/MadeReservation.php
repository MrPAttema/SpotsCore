<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use DB;
use Crypt;
use App;

class MadeReservation extends Notification
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
        return ['mail', 'database'];
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
        ->greeting('Bedankt voor uw reservering!')
        ->subject($appName.' - Uw nieuwe reservering')
        ->line('Wij danken u hartelijk voor uw reservering.')
        ->line('Uw reservering is verwerkt met reserveringnummer #'.$reservationID.'.')
        ->line('Verblijf: '.$location->location_name)
        ->line('Locatie: '.$location->location_location)
        ->line('De status van uw reservering kunt u altijd bekijken op de website.')
        ->action('Bekijk de status hier', $url)
        ->line('Wij zullen u op de hoogte houden door middel van een email van eventuele status wijzigingen op uw account.')
        ->success();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $reservation
     * @return array
     */
    public function toDatabase($notifiable)
    {    
        return [
            'id' => $notifiable->id,
            'reservation_id' => $this->reservation->id,
            'location_id' => $this->reservation->location_id,
        ];
    }

}
