<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

use App\Reservation;
use App\Payment;
use App\Touristtax;
use App\Location;
use DB;

class MyReservationController extends Controller
{
    public function __construct() {

      $this->middleware('auth');
      
    }

    public function index() {

        $user_id = Auth::id();
        $reservations = App\Reservation::with('payment', 'touristtax', 'location')->where('user_id', $user_id)->orderBy('id', 'desc')->paginate(5);  
        $touristTax = DB::table('options')->where('id', 14)->value('value');
        return view('reservations.myreservations', compact('reservations', 'touristTax'));
        
    }
    
}
