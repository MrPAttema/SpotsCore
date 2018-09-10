<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
      	'location_name', 
      	'location', 
        'location_discription', 
        'location_date_low',
        'location_price_low',
        'location_price', 
        'location_price_high',
        'location_date_high',
        'location_tax',
        'location_entertime',
        'location_fridge',
        'locsation_central_heating',
        'location_coffee',
        'location_washingmachine' ,       
        'location_dryer',
        'location_dishwasher',
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
