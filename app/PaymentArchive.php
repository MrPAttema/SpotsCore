<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PaymentArchive extends Model
{
    protected $fillable = [
        'reservation_id', 
        'location_id' , 
        'payment_time', 
        'payment_status', 
        'payment_price', 
        'payment_tax'
    ];

    public function paymentArchive()
    {
        return $this->belongsTo('App\ReservationArchive', 'reservation_id_old');
    }
}
