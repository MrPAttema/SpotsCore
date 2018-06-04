<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    public function userArchive() {

        return $this->hasOne('App\UserArchive');
    }

    public function locationArchive() {
        
        return $this->belongsTo('App\LocationArchive');
    }

    public function paymentArchive() {

        return $this->hasOne('App\PaymentArchive', 'reservation_id');
    }

    public function touristtaxArchive() {
    	
        return $this->hasOne('App\TouristtaxArchive', 'reservation_id');
    }
}
