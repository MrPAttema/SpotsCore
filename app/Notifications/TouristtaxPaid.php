<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TouristtaxPaid extends Notification
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
      $url = url('/reservations/myreservations/');
      return (new MailMessage)
        ->greeting('Geachte mevr. / mijnheer.')
        ->subject('Mijn Belboei - Betaling Verwerkt')
        ->line('Wij willen u met deze email op de hoogste stellen dat wij uw betaling voor de toeristenbelasting hebben ontvangen en verwerkt.')
        ->line('U kunt de status van de betaling zien door op de onderstaande knop te klikken.')
        ->line('Ook kunt u nu via de website uw factuur inzien en deze eventueel uitprinten.')
        ->action('Bekijk de status hier', $url)
        ->line('Wij hopen dat we u in de toekomst weer in de Belboei als huurder mogen ontvangen.')
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
