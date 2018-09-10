<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use App\Location;
use DB;

class AccommodationsController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index()
  {
      $locations = App\Location::all();
      $autotoewijzen = DB::table('options')->where('id', 2)->value('value');
      $ronde1 = DB::table('options')->where('id', 3)->value('value');
      $ronde2 = DB::table('options')->where('id', 4)->value('value');
      $touristTax = DB::table('options')->where('id', 14)->value('value');
    //   dd($locations);
      return view('accomodations.all', compact('locations', 'autotoewijzen', 'ronde1', 'ronde2', 'touristTax'));
  }

}
