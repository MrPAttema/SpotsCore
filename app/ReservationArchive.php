<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ReservationArchive extends Model
{
    protected $fillable = [

        'user_id', 
        'phone', 
        'adress', 
        'postcode', 
        'city', 
        'location_id', 
        'res_year',
        'res_status',
        'res_week1', 
        'res_week2', 
        'res_week3', 
        'res_akkoord', 
        'aanvraagtijd',
        'res_toegewezen_week',
    ];

    public function locationArchive()
    {
        return $this->belongsTo('App\LocationArchive', 'location_id');
    }

    public function userArchive()
    {
        return $this->hasOne('App\UserArchive', 'id');
    }

    public function paymentArchive()
    {
        return $this->hasOne('App\PaymentArchive', 'reservation_id', 'reservation_id_old');
    }

    public function touristtaxArchive()
    {
        return $this->hasOne('App\TouristtaxArchive', 'reservation_id', 'reservation_id_old');
    }
}