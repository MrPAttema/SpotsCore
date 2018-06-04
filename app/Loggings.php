<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Loggings extends Model
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
    
    public function user()
    {
        return $this->hasOne('App\User');
    }
}