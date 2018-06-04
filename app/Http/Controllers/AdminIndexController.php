<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Admin;
use App\Reservation;
use App\Payment;
use App\Touristtax;
use App\Location;
use DB;

class AdminIndexController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth:admin');
  }

  public function index()
  {
        $users = DB::table('users')->orderBy('created_at', 'desc')->first();
        $boekingsjaar = DB::table('options')->where('id', 1)->value('value');
        $reservations = App\Reservation::with('payment', 'touristtax', 'location')->orderBy('created_at', 'desc')->get();
        $softwareKey = DB::table('options')->where('id', 7)->value('value');
        $currentSoftwareVersion = DB::table('options')->where('id', 8)->value('value');
        $currentAPIVersion = DB::table('options')->where('id', 9)->value('value');
        $currentSoftwareID = DB::table('options')->where('id', 10)->value('value');   
        $currentSoftwareStatus = DB::table('options')->where('id', 11)->value('value');
      return view('admin.index', compact('reservations', 'users', 'boekingsjaar', 'currentSoftwareVersion', 'currentAPIVersion', 'currentSoftwareID', 'currentSoftwareStatus'));
  }
}
