<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Touristtax;
use Mollie;
use DB;

class TouristtaxController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index(Request $request)
  {
      $reservation_id = $request->input('reservation_id');
      $location_id = $request->input('location_id');
      $is_archive = $request->input('is_archive');
      $amount = DB::table('locations')->where('id', $location_id)->value('location_tax');
      return view('touristtax.new', compact('location_id', 'reservation_id', 'amount', 'is_archive'));
  }

  public function store(Request $request)
  {
        {
            $touristtax = Touristtax::create([
                'reservation_id' => $reservation_id,
                'touristtax_status' => 0,
                'touristtax_price' => 0,
                'za_zo' => $request->input('za-zo'),
                'zo_ma' => $request->input('zo-ma'),
                'ma_di' => $request->input('ma-di'),
                'di_wo' => $request->input('di-wo'),
                'wo_do' => $request->input('wo-do'),
                'do_vrij' => $request->input('do-vrij'),
                'vrij_za' => $request->input('vrij-za'),
            ]);
        }

          // return redirect('/reservations/myreservations');

 }

}
