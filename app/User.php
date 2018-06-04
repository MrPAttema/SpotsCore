<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'firstname', 
        'username',
        'facebook_id', 
        'lastname', 
        'provider_user_id', 
        'provider', 
        'email', 
        'password', 
        'adress', 
        'postcode', 
        'city', 
        'birthday', 
        'work_location', 
        'work_department',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservations()
    {
        return $this->hasMany('App\Reservations');
    }

    public function loggings()
    {
        return $this->hasMany('App\Loggings');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
