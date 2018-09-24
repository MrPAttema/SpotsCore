<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priorities extends Model
{
    protected $table = 'priorities';
        
    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function reservation()
    {
        return $this->hasOne('App\Reservation');
    }
}
