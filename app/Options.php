<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{

  protected $fillable = [
      	'firstname', 
      	'lastname', 
      	'email', 
      	'password', 
      	'ronde1', 
        'ronde2',
        'autoarchief',
      	'autotoewijzen',
      	'dubbeleboekingen',
  ];


}
