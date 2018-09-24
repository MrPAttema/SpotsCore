<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

use App\Adminreservations;
use App\Reservation;
use App\User;
use App\Priorities;
use App;
use Crypt;
use Carbon\Carbon;
use Session;
use DB;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ReservationAssign;
use App\Notifications\ReservationCancelled;
use App\Notifications\ReservationRejected;


class AdminReservationsController extends Controller
{

  	use Notifiable;

  	public function __construct()
  	{
	  	$this->middleware('auth:admin');
  	}

  	public function index(Request $request)
  	{
  		$results = "NULL";
        $reservations = App\Reservation::with('payment', 'touristtax', 'location', 'user')->where('deleted', NULL)->orderBy('res_toegewezen_week', 'asc')->paginate(20);
        return view('admin.allreservations', compact('reservations', 'results'));
  	}

  	public function update(Request $request)
  	{
        $id = $request->reservation_id;

        $boekingsjaar = DB::table('options')->where('id', 1)->value('value');
        $weekcheck = DB::table("occupied_weeks_$boekingsjaar")->where('week', $request->input('toegewezen'))->value('bezet');

        if ($weekcheck == 0) {
            
            $submission = App\Reservation::where('id', $id)->update([
                'res_toegewezen_week' => $request->input('toegewezen'),
                'res_status' => 1,
            ]);

            $reservation = App\Reservation::with('payment', 'touristtax', 'location', 'user')->where('id', $id)->get()->toArray();
            $reservation = array_shift($reservation);
            $reservation = (object) $reservation;

            DB::table("occupied_weeks_$boekingsjaar")->where('week', $request->input('toegewezen'))->update(['bezet' => 1]);

            $user_id = App\Reservation::where('id', $id)->value('user_id');
            $user = User::find($user_id);
            $user->notify(New ReservationAssign($reservation));

            $request->session()->flash('message', 'Reservering #'. $id .' is geupdate.');
            return redirect('/admin/allreservations');

        } else {

            $toegewezen = $request->input('toegewezen');
            
            $request->session()->flash('error', 'Week '. $toegewezen .' is al uitgegeven.');
            return redirect('/admin/allreservations'); 

        }	
    }
      
    public function autoAssign(Request $request) {

        $currentYear = Carbon::now();

        $res_year = DB::table('options')->where('id', 1)->value('value');

        $resWeek = $request->input('round');

        switch ($resWeek) {
            case '1':
                $resWeek = 'res_week1';
            break;
            case '2':
                $resWeek = 'res_week2';
            break;
            case '3':
                $resWeek = 'res_week3';
            break;
            case '4':
                $resWeek = 'res_week4';
            break;          
            default:
                # code...
            break;
        }
        
        $reservations = App\Reservation::with('user')->orderBy($resWeek)->where('res_year', $res_year)->where('deleted', null)->where('res_status', 0)->get();

        foreach ($reservations as $reservation) {
         
            $priority = DB::table('priorities')->where('employee_id', $reservation->user->employee_id)->get()->toArray();

            $priority = array_shift($priority);

            $count = 0;

            if(isset($priority)) {
                if (end($priority) === 'IN') {
                    $count = 1;
                } else {            
                    foreach ($priority as $priorityType) {
                        if ($priorityType === 'UIT') {
                            $count++;
                        } elseif (($priorityType === 'IN') || ($priorityType === '0')) {
                            $count = 0;
                        }
                    }
                }
            }
            if ($count === 0) {
                $count++;
            }
            $priority = $count;
            
            $reservation->priority = $priority;    

            $reservation = json_decode(json_encode($reservation),true);

            $reservations_all[] = $reservation;
        }
        
        $reservations_all = collect($reservations_all)->sortBy('priority')->reverse()->toArray();

        $freeWeeks = DB::table("occupied_weeks_$res_year")->where('bezet', 0)->get()->toArray();
        
        $count = count($freeWeeks);
 
        for ($x = 0; $x <= $count; $x++) {
            
            

        } 

        dump($reservations_all);
        
        exit;

        
        // return redirect('/admin/options');              
    }

    public function reject(Request $request){
        
        $reservation_id = $request->reservation_id;
        $reservation = Reservation::findOrFail($reservation_id);

        $submission = App\Reservation::where('id', $reservation_id)->update([
          'deleted' => 1,
          'res_status' => 2,
        ]);

        $user_id = App\Reservation::where('id', $reservation_id)->value('user_id');
        $user = User::find($user_id);
        $user->notify(New ReservationRejected($submission));

        Session::flash('message', 'Reservering #'. $reservation_id .' is afgewezen.');
        return redirect('/admin/allreservations');
    }

  	public function cancel(Request $request){
        
        $reservation_id = $request->reservation_id;
        $reservation = Reservation::findOrFail($reservation_id);

        $submission = App\Reservation::where('id', $reservation_id)->update([
          'deleted' => 1,
          'res_status' => 3,
        ]);

        $user_id = App\Reservation::where('id', $reservation_id)->value('user_id');
        $user = User::find($user_id);
        $user->notify(New ReservationCancelled($submission));

        Session::flash('message', 'Reservering #'. $reservation_id .' is geannuleerd.');
        return redirect('/admin/allreservations');
    }
}
