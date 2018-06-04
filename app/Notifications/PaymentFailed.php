<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentFailed extends Notification
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
        $paymenturl = url('/reservations/myreservations');
        return (new MailMessage)
            ->greeting('Geachte mevr. / mijnheer!')
            ->subject('VVMCL.nl - Betaling mislukt')
            ->line('Wij hebben van uw bank ontvangen dat de betaling die u recentelijk heeft gedaan niet is geslaagd.')
            ->line('Dit kan twee verschillende redenen hebben, of u heeft de betaling niet voltooid, of uw bank had op het moment van betalen een storing. Wij adviseren om contact op te nemen met uw bank als er wel geld af is geschreven van uw bankrekening.')
            ->line('Als u de betaling heeft afgebroken verzoeken wij deze alsnog uit te voeren, u kunt hieronder klikken om een nieuwe betaling te doen.')
            ->action('Direct Betalen', $paymenturl)
            ->line('Mocht er nog een betalings statuswijziging plaatsvinden dan houden wij u op de hoogte via een nieuwe mail.')
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
