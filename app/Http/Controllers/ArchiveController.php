<?php

namespace App\Http\Controllers;

use App;
use Auth;
use App\ReservationArchive;
use App\PaymentArchive;
use App\TouristtaxArchive;
use App\LocationArchive;
use App\UserArchive;
use App\User;
use DB;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class ArchiveController extends Controller
{
    public function __construct() {

	  	$this->middleware('auth');
	}

  	public function adminIndex(Request $request) {
          
        $res_year = NULL;

        $records = DB::table('user_archives')  
            ->join('reservation_archives', 'reservation_archives.user_id', '=', 'user_archives.id')               
            ->join('touristtax_archives', 'reservation_archives.id', '=', 'touristtax_archives.id')
            ->join('payment_archives', 'reservation_archives.id', '=', 'payment_archives.id')
            ->join('locations', 'reservation_archives.location_id', '=', 'locations.id')
            ->select('touristtax_archives.*', 'payment_archives.*', 'locations.*', 'user_archives.*', 'reservation_archives.*')
            ->distinct()->get();
  
		return view('archive.adminindex', compact('records', 'res_year'));
    }

    public function adminYeardata(Request $request) {

        $user_id = Auth::id();
        $user = User::find($user_id);
        $res_year = $request->res_year;

        $records = DB::table('reservation_archives')
            ->distinct('reservation_archives.email')
            ->join('user_archives', 'reservation_archives.user_id', '=', 'user_archives.id')                 
            ->join('touristtax_archives', 'reservation_archives.id', '=', 'touristtax_archives.id')
            ->join('payment_archives', 'reservation_archives.id', '=', 'payment_archives.id')
            ->join('locations', 'reservation_archives.location_id', '=', 'locations.id')
            ->where('reservation_archives.res_year', '=', $res_year)
            ->where('reservation_archives.res_toegewezen_week', '>', 0)
            ->orderBy('reservation_archives.res_toegewezen_week', 'ASC')
            ->select('touristtax_archives.*', 'payment_archives.*', 'locations.*', 'user_archives.*', 'reservation_archives.*')
            ->get();

        return view('archive.adminindex', compact('records', 'res_year', 'res_id'));
    }

    public function updateTaxPayment(Request $request) {

        $id = $request->reservation_id;
        $res_year = $request->res_year;
        $date = $request->toeristenbelasting;

        $update = DB::table('touristtax_archives')->where('id', $id)->update([
            'tax_status' => 1,
            'updated_at' => $date
        ]);

        $records = DB::table('reservation_archives')  
            ->join('user_archives', 'reservation_archives.user_email', '=', 'user_archives.email')                 
            ->join('touristtax_archives', 'reservation_archives.id', '=', 'touristtax_archives.id')
            ->join('payment_archives', 'reservation_archives.id', '=', 'payment_archives.id')
            ->join('locations', 'reservation_archives.location_id', '=', 'locations.id')
            ->where('reservation_archives.res_year', '=', $res_year)
            ->where('reservation_archives.res_toegewezen_week', '>', 0)
            ->orderBy('reservation_archives.res_toegewezen_week', 'ASC')
            ->select('touristtax_archives.*', 'payment_archives.*', 'locations.*', 'user_archives.*', 'reservation_archives.*')
            ->get();

        return redirect()->action('ArchiveController@adminYeardata', ['res_year' => $res_year]);
        // return view('/admin/archive/yeardata', compact('records', 'res_year', 'res_id'))->with('res_year');
        // return redirect('/admin/archive/yeardata', compact('records', 'res_year', 'res_id'));
    }
    
    public function updateRentPayment(Request $request) {

        $id = $request->reservation_id;
        $res_year = $request->res_year;
        $date = $request->huurbetaling;

        $update = DB::table('payment_archives')->where('id', $id)->update([
            'payment_status' => 1,
            'updated_at' => $date
        ]);

        $records = DB::table('reservation_archives')  
            ->join('user_archives', 'reservation_archives.user_email', '=', 'user_archives.email')                 
            ->join('touristtax_archives', 'reservation_archives.id', '=', 'touristtax_archives.id')
            ->join('payment_archives', 'reservation_archives.id', '=', 'payment_archives.id')
            ->join('locations', 'reservation_archives.location_id', '=', 'locations.id')
            ->where('reservation_archives.res_year', '=', $res_year)
            ->where('reservation_archives.res_toegewezen_week', '>', 0)
            ->orderBy('reservation_archives.res_toegewezen_week', 'ASC')
            ->select('touristtax_archives.*', 'payment_archives.*', 'locations.*', 'user_archives.*', 'reservation_archives.*')
            ->get();
        
        return redirect()->action('ArchiveController@adminYeardata',  ['res_year' => $res_year]);
        // return view('archive.adminindex', compact('records', 'res_year', 'res_id'))->with('res_year');
        // return redirect('/admin/archive/yeardata', compact('records', 'res_year', 'res_id'));
	}

	public function index(Request $request) {

        $records = NULL;	
        $res_year = NULL;

		return view('archive.index', compact('records', 'res_year'));
	}

	public function yeardata(Request $request) {

        // Get Current User Data
        $current_user_id = Auth::id();
        $current_user = User::find($current_user_id);
        $current_user_email = $current_user->email;
        // Get Old User Data
        $old_user_id = DB::table('user_archives')->where('email', $current_user_email)->value('id');
        $res_year = $request->res_year;

        $records = DB::table('reservation_archives')
                ->join('user_archives', 'reservation_archives.user_id', '=', 'user_archives.id')          
                ->join('touristtax_archives', 'reservation_archives.id', '=', 'touristtax_archives.id')
                ->join('payment_archives', 'reservation_archives.id', '=', 'payment_archives.id')
                ->join('locations', 'reservation_archives.location_id', '=', 'locations.id')
                ->where('reservation_archives.user_id', '=', $old_user_id)
                ->where('reservation_archives.res_year', '=', $res_year)
                ->select('touristtax_archives.*', 'payment_archives.*', 'locations.*', 'user_archives.*', 'reservation_archives.*')
                ->distinct('user_archives.email')->get();

		return view('archive.index', compact('records', 'res_year', 'res_id'));
	}
}
