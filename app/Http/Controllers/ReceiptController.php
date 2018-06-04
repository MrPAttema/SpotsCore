<?php

namespace App\Http\Controllers;

use App;
use App\Reservation;
use App\Payment;
use App\Location;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index(Request $request)
  {
      $res_id = $request->reservation_id;
      $reservations = App\Reservation::with('touristtax', 'location', 'user')->where('id', $res_id)->get();

      return view('invoice.receipt', compact('reservations'));
  }
}
