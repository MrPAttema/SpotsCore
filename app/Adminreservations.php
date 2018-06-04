<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Adminreservations extends Model
{
    use Notifiable;

    public function user()
    {
        return $this->hasOne('App\User', 'id');
    }
}
