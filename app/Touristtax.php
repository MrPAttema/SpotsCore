<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Touristtax extends Model
{
    use Notifiable;

    protected $fillable = [
      'reservation_id', 
      'tax_status', 
      'tax_price', 
      'za_zo', 
      'zo_ma', 
      'ma_di', 
      'di_wo', 
      'wo_do', 
      'do_vrij', 
      'vrij_za', 
      'persons',
    ];

    public function touristtax()
    {
      return $this->belongsTo('App\Reservation');
    }
}
