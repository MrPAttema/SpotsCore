<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationRejected extends Notification
{
    use Queueable;

    protected $submission;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($submission)
    {
        $this->submission = $reservation;
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
        $url = url('https://mijn.belboeivlieland.nl/login');
        return (new MailMessage)    
          ->greeting('Geachte mevr. / mijnheer.')
          ->subject($appName.' - Uw reservering status')
          ->line('Wij willen u met deze email op de hoogste stellen dat de status van uw reserveringaanvraag met reserveringsnummer #'.$reservationID.' is veranderd naar "afgewezen".')
          ->line('Dit houd in dat u de volgende ronde weer kunt reserveren op een overgebleven week.')
          ->line('Wij zullen u altijd op de hoogte houden door middel van een email van status wijzigingen op uw account.')
          ->action('Ga naar Mijn Belboei', $url)
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
