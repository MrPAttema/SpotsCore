<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

use App\Adminreservations;
use App\Reservation;
use App\User;
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

            DB::table("occupied_weeks_$boekingsjaar")->where('week', $request->input('toegewezen'))->update(['bezet' => 1]);

            $user_id = App\Reservation::where('id', $id)->value('user_id');
            $user = User::find($user_id);
            (new User)->forceFill([
                'id' => $user->id,
                'email' => Crypt::decrypt($user->email),
            ])->notify(New ReservationAssign($submission));

            Session::flash('message', 'Reservering #'. $id .' is geupdate.');
            return redirect('/admin/allreservations');

        } else {

            $toegewezen =  $request->input('toegewezen');
            
            Session::flash('error', 'Week '. $toegewezen .' is al uitgegeven.');
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
        
        for ($x = 0; $x <= 53; $x++) {

            $reservations = App\Reservation::where('res_year', $res_year)->where($resWeek, $x)->where('deleted', null)->where('res_status', 0)->get()->toArray();
            
            if (!empty($reservations)) {
                
                if (count($reservations) == 1) {
                    
                    // $reservation = $reservations;
                    
                    // $reservation = array_shift($reservation);
                    
                    // $weekcheck = DB::table("occupied_weeks_$res_year")->where('week', $reservation[$resWeek])->value('bezet');
                    
                    // if ($weekcheck == 0) {
                        
                        //     $submission = App\Reservation::where('id', $reservation['id'])->update([
                            //         'res_toegewezen_week' => $reservation[$resWeek],
                            //         'res_status' => 1,
                            //     ]);
                            
                            //     DB::table("occupied_weeks_$res_year")->where('week', $reservation[$resWeek])->update(['bezet' => 1]);
                            
                            //     $user_id = App\Reservation::where('id', $reservation['user_id'])->value('user_id');
                            //     $user = User::find($user_id);
                            //     $user->notify(New ReservationAssign($reservation));
                            // }  
                            
                } else {
                    
                    dump($reservations);

                    $reservation = $reservations;

                    $reservation = array_shift($reservation);

                    $weekcheck = DB::table("occupied_weeks_$res_year")->where('week', $reservation[$resWeek])->value('bezet');
                    
                    if ($weekcheck == 0) {

                        $currentYear = $reservation['res_year'];
                        $reservationsArchive = DB::table('reservation_archives')->where('user_id', $reservation['user_id'])->get()->toArray();
                        $reservationsArchive = array_shift($reservationsArchive);
                        
                        $reservationsOld = DB::table('reservations_old')->where('employee_id', '102367')->get()->toArray();
                        // $reservationsOld = array_shift($reservationsOld);
                        
                        $count = 0;
                        $currentYear = 2018;  

                        for ($year = 2011; $year <= $currentYear; $year++) {

                            foreach ($reservationsOld as $reservationOld) {

                                dump($reservationOld->$year);
                                                            
                                if ($reservationOld->employee_id == 'UIT') {
                                    $count++;
                                }
                            }

                        }

                        // $submission = App\Reservation::where('id', $reservation['id'])->update([
                        //     'res_toegewezen_week' => $reservation[$resWeek],
                        //     'res_status' => 1,
                        // ]);

                        // DB::table("occupied_weeks_$res_year")->where('week', $reservation[$resWeek])->update(['bezet' => 1]);

                        // $user_id = App\Reservation::where('id', $reservation['user_id'])->value('user_id');
                        // $user = User::find($user_id);
                        // $user->notify(New ReservationAssign($reservation));             
                    }  
                }
            }
        } 
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
        (new User)->forceFill([
            'id' => $user->id,
            'email' => Crypt::decrypt($user->email),
        ])->notify(New ReservationRejected($submission));

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
        (new User)->forceFill([
            'id' => $user->id,
            'email' => Crypt::decrypt($user->email),
        ])->notify(New ReservationCancelled($submission));

        Session::flash('message', 'Reservering #'. $reservation_id .' is geannuleerd.');
        return redirect('/admin/allreservations');
    }
}
