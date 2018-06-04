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
use Session;

use DB;

class BalieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:balie');
    }

    public function index(Request $request)
    {
        $keys = DB::table('super_keys')->get();

        $reservations = App\Reservation::with('payment', 'location', 'user')->where('res_toegewezen_week', '>', 0)->orderBy('res_toegewezen_week', 'asc')->paginate(20);
        return view('balie.allreservations', compact('reservations', 'keys'));
    }

    public function update(Request $request)
    {
        $key_id = $request->input('key_id');

        $key_status = DB::table('super_keys')->where('id', $key_id)->value('key_status');

        if ($key_status == 1) {

            Session::flash('error', 'De geselecteerde sleutel is al uitgegeven.');
        } else {

            DB::table('super_keys')->where('key_id', $key_id)->update(['key_status' => 1]);
        }
        return redirect('balie');   
    }
}
