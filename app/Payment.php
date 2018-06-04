<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Payment extends Model
{
    protected $fillable = [
        'reservation_id', 
        'location_id' , 
        'payment_time', 
        'payment_status', 
        'payment_price', 
        'payment_tax'
    ];

    public function reservation()
    {
        return $this->belongsTo('App\Reservation');
    }
}
