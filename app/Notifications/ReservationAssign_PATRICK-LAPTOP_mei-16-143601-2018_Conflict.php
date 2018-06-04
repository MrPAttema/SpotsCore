<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;
use DB;

class ReservationAssign extends Notification
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
        if (!is_array($this->reservation)) {
            foreach ($this->reservation as $reservation) {
            }
        } else {
            $reservation = (object) $this->reservation;
        }
        
        $locations = DB::table('locations')->where('id', $reservation->location_id)->get()->toArray();
        $locations = array_shift($locations);
        $location = (object) $locations;
        $reservationID = $reservation->id;
        $locationEnterDay = $location->change_day;
        if ($locationEnterDay == 6) {
            Carbon::setWeekStartsAt(Carbon::SATURDAY);
            Carbon::setWeekEndsAt(Carbon::SATURDAY);
        } elseif ($locationEnterDay == 5) {
            Carbon::setWeekStartsAt(Carbon::FRIDAY);
            Carbon::setWeekEndsAt(Carbon::FRIDAY);
        } 

        $carbon = Carbon::now();
        
        $carbon->setISODate($reservation->res_year, $reservation->res_toegewezen_week);
        $enterDate = $carbon->startOfWeek()->format('d-m-Y');
        $exitDate = $carbon->addWeek()->format('d-m-Y');          
            
        $url = url('/reservations/myreservations');
        return (new MailMessage)
            ->greeting('Geachte mevr. / mijnheer.')
            ->subject($appName.' - Uw reservering status')
            ->line('Met deze email willen wij u op de hoogste stellen dat de status van uw reservering met reserveringnummer #'.$reservationID.' is veranderd naar "toegewezen".')
            ->line('Wij hopen dat u spoedig een goed verblijft heeft.')
            ->line('Hieronder vind uw een paar details over uw reservering:')
            ->line('<b>Details van uw reservering:</b>')
            ->line('<b>Verblijf: </b>'.$location->location_name)
            ->line('<b>Locatie: </b>'.$location->location_location)
            ->line('<b>Aankomst na: </b>'.$location->location_entertime.', op ' .$enterDate)
            ->line('<b>Vertrek voor: </b>'.$location->location_exittime. ', op ' .$exitDate)
            ->line('Wij zullen u altijd op de hoogte houden door middel van een email van status wijzigingen op uw account.')
            ->line('Graag wijzen wij u op het feit dat de huur tenminste 14 dagen voor vertrek door ons ontvangen moet zijn.')
            ->line('Uw reservering kunt u middels iDeal op mijn Belboei betalen door op de onderstaande knop te gebruiken. Uiteraard kan dat ook op een later moment als u deze mail bewaard.')
            ->action('Betaal huur', $url)
            ->line('De toeristenbelasting dient na terugkomst van uw verblijf te worden betaald, hier krijg u na uw verblijf automatisch een herinnering over.')
            ->line('U kunt tijdens kantooruren de sleutel afhalen bij de ontvangstbalie van Zorgplein Harlingen, Achlumerdijk 2, 8862 AJ te Harlingen.')
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
