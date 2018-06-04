<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserArchive extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 
        'lastname', 
        'email', 
        'password', 
        'adress', 
        'postcode', 
        'city', 
        'birthday', 
        'work_location', 
        'work_department',
    ];


    public function userArchive()
    {
        return $this->belongsTo(UserArchive::class);
    }

    public function archives()
    {
        return $this->hasMany('App\ReservationArchive');
    }

}
