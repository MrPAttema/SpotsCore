<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use Notifiable;

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

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function payment()
    {
        return $this->hasOne('App\Payment', 'reservation_id');
    }

    public function touristtax()
    {
        return $this->hasOne('App\Touristtax', 'reservation_id');
    }
}
