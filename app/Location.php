<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
      	'location_name', 
      	'location', 
      	'location_discription', 
      	'location_price', 
      	'location_entertime', 
      	'location_exittime', 
      	'location_wifi', 
      	'location_tv', 
      	'location_radio', 
      	'location_shower', 
      	'location_publictransport',
    ];

    public function location()
    {
      return $this->belongsTo('App\Reservation');
    }
}
