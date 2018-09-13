<?php

namespace App\Http\Controllers;

use DB;
use App;
use Crypt;
use Session;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MadeReservation;
use App\Notifications\ReservationAssign;
use App\Notifications\MadeReservation as Mailable;
use Illuminate\Notifications\Notifiable;
use App\User;
use App\Payment;
use App\Touristtax;
use App\Reservation;

class ReservationController extends Controller
{

    public function __construct() {

        $this->middleware('auth');
    }

    public function index(Request $request) {

        $currentDateTime = Carbon::now();
        $currentYear = $currentDateTime->year;
        $ronde1 = DB::table('options')->where('id', 3)->value('value');
        $ronde2 = DB::table('options')->where('id', 4)->value('value');

        if ( ($ronde1 == 1) || ($ronde2 == 1) ) {

            $location_id = $request->get('location_id');
            $location = DB::table('locations')->where('id', $location_id)->get();
            $res_year = DB::table('options')->where('id', 1)->value('value');
            if ($res_year == $currentYear) {
                $res_yearOld = "";
            } else {
                $res_yearOld = $res_year-1;
            }
            $autotoewijzen = DB::table('options')->where('id', 2)->value('value');

            return view('reservations.new', compact('makereservations', 'res_year', 'res_yearOld', 'location', 'autotoewijzen'));

        } else {

            $request->session()->flash('error', 'Reserveren is niet mogelijk. Probeer het later nog een keer.');
            return redirect('accommodations/all');

        }      
    }

    public function stepTwo(Request $request) {

        $res_year = $request->get('res_year');
        $location_id = $request->get('location_id');

        $validator = Validator::make($request->all(), [
            'res_year' => 'required',
            'location_id' => 'required',
        ])->validate();

        // $dubbleChseck = DB::table('reservations')->where('user_id', Auth::id())->where('res_year', $res_year)->where('res_status', 1)->get(); 

        $ronde1 = DB::table('options')->where('id', 3)->value('value');
        $ronde2 = DB::table('options')->where('id', 4)->value('value');
        $taxtype = DB::table('options')->where('id', 16)->value('value');

        if ( ($ronde1 == 1) || ($ronde2 = 1) ) {
            

            $location = DB::table('locations')->where('id', $location_id)->get()->toArray();
            $location = array_shift($location);
            $touristTax = DB::table('options')->where('id', 14)->value('value');
            
            $occupiedWeeks = DB::table('occupied_weeks_' . $res_year)->where('location_id', $location_id)->where('bezet', 0)->get()->toArray();

            $datesLow = explode(",", $location->location_date_low);
            $datesHigh = explode(",", $location->location_date_high);
            $weeks = array();

            $amount_low = DB::table('locations')->where('id', $location_id)->value('location_price_low');
            $amount_normal = DB::table('locations')->where('id', $location_id)->value('location_price');
            $amount_high = DB::table('locations')->where('id', $location_id)->value('location_price_high');
            
            foreach ($occupiedWeeks as $week) {
                if (in_array($week->week, $datesLow) == true) {
                    $week->type = " - (Actieweek)";
                } else if (in_array($week->week, $datesHigh) == true) {
                    $week->type = " - (Hoogseizoen)";
                } else {
                    $week->type = "";
                }
                array_push($weeks, $week);
            }

            return view('reservations.new_steptwo', compact('weeks', 'datesHigh', 'amount_low','amount_high', 'res_year', 'location', 'location_id', 'ronde1', 'ronde2', 'touristTax', 'enterDate', 'exitDate', 'taxtype'));

        } else {

            $request->session()->flash('error', 'Reserveren is niet mogelijk. Probeer het later nog een keer.');
            return redirect('accommodations/all'); 

        }     
    }

    public function getPriceData(Request $request) {

        $location_id = $request['location_id'];
        $res_year = $request['res_year'];
        $selectedWeek = $request['week'];
        $location = DB::table('locations')->where('id', $request['location_id'])->get()->toArray();
        $location = array_shift($location);
        $touristTax = DB::table('options')->where('id', 14)->value('value');

        $locationEnterDay = $location->change_day;
        if ($locationEnterDay == 6) {
            Carbon::setWeekStartsAt(Carbon::SATURDAY);
            Carbon::setWeekEndsAt(Carbon::SATURDAY);
        } elseif ($locationEnterDay == 5) {
            Carbon::setWeekStartsAt(Carbon::FRIDAY);
            Carbon::setWeekEndsAt(Carbon::FRIDAY);
        } 

        $carbon = Carbon::now();
        
        $locationDates = $location->location_date_high;
        $datesLow = explode(",", $location->location_date_low);
        $datesHigh = explode(",", $location->location_date_high);
        $priceData = new \stdClass();
        
        $amount_low = DB::table('locations')->where('id', $location_id)->value('location_price_low');
        $amount_normal = DB::table('locations')->where('id', $location_id)->value('location_price');
        $amount_high = DB::table('locations')->where('id', $location_id)->value('location_price_high');
        
        if (in_array($selectedWeek, $datesHigh) == true) {
            $priceData->price = $amount_high;
        } else if (in_array($selectedWeek, $datesLow) == true) {
            $priceData->price = $amount_low;
        } else {
            $priceData->price = $amount_normal;

        }
        $priceData->week = $selectedWeek;
        $priceData->tax = $location->location_tax;
        $carbon->setISODate($res_year, $selectedWeek);
        $enterDate = $carbon->startOfWeek()->format('d-m-Y');
        $exitDate = $carbon->addWeek()->format('d-m-Y');
        $priceData->enterDate = $enterDate;
        $priceData->exitDate = $exitDate;

        return json_encode($priceData);

    }

    public function stepThree(Request $request) {

        $requestData = $request->all();
        // dd($requestData);
           
        $res_year = $request->get('res_year');
        $location_id = $request->get('location_id');
        $res_week1 = $requestData['weekOne']; 

        if (!isset($requestData['weekTwo']) && ($requestData['two_weeks_together'])) {
            
            $res_week2 = $requestData['weekOne'] +1;

        } else {

            $res_week2 = $requestData['weekTwo'];

        }
        
        $location = DB::table('locations')->where('id', $location_id)->get();
        $occupied_weeks = DB::table('occupied_weeks_' . $res_year)->where('bezet', 0)->get(); 
        return view('reservations.new_stepthree', compact('location_id', 'res_week1', 'res_week2', 'res_year'));  
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'res_akkoord' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('reservations/new/stepthree')
                        ->withErrors($validator)
                        ->withInput();
        }

        $user_id = Auth::id();
        $user = User::find($user_id);
        $request = $request->all();
        $res_year = $request['res_year'];
        $res_week1 = $request['res_week1'];
        $res_location_id = $request['location_id'];

        $worklocation = DB::table('users')->where('id', $user_id)->value('work_location');

        $autotoewijzen = DB::table('options')->where('id', 2)->value('value');
        $ronde1 = DB::table('options')->where('id', 3)->value('value');
        $ronde2 = DB::table('options')->where('id', 4)->value('value');
        $dubbeleboekingen = DB::table('options')->where('id', 5)->value('value');       
        
        $reservation_id = "$res_year$res_location_id$res_week1";

        $bezetCheck = DB::table("occupied_weeks_$res_year")->where('week', $request['res_week1'])->value('bezet');
        $dubbleCheck = DB::table('reservations')->where('user_id', $user_id)->where('res_year', $res_year)->where('res_status', 1)->get();

        if ($bezetCheck == 1)  {

            Session::flash('error', 'Week '. $request['res_week1'] .' is al uitgegeven. Onze excuuses voor het ongemak.');
            return redirect('/accommodations/all'); 

        } elseif ( ($dubbeleboekingen == 0) && (!$dubbleCheck->isEmpty() ) ) {

            Session::flash('error', 'U heeft al een toegewezen week in '. $res_year . '. Dubbele boekingen zijn niet toegestaan.');
            return redirect('/accommodations/all');

        } else {

            if (($ronde1 == 1) && ($ronde2 == 0)) {

                $res_status = 0;
                $res_ronde = 1;
                $res_week1 = $res_week1;
                $res_week2 = $request['res_week2'];
                $res_week3 = 0;
                $res_toegewezen_week = 0;
                $bezet = 0;

            } elseif (($ronde1 == 0) && ($ronde2 == 1)) {

                if ( ($worklocation == "GeenZPF") || ($worklocation == "Geen ZPF") ) {

                    $res_status = 0;
                    $res_ronde = 2;
                    $res_week1 = 0;
                    $res_week2 = 0;
                    $res_week3 = $res_week1;
                    $res_toegewezen_week = 0;
                    $bezet = 0;  

                }
                elseif ($autotoewijzen == 1) {

                    $res_status = 1;
                    $res_ronde = 2;
                    $res_week1 = 0;
                    $res_week2 = 0;
                    $res_week3 = $res_week1;
                    $res_toegewezen_week = $res_week1;
                    $bezet = 1;

                } elseif ($autotoewijzen == 0) {

                    $res_status = 0;
                    $res_ronde = 2;
                    $res_week1 = 0;
                    $res_week2 = 0;
                    $res_week3 = $res_week1;
                    $res_toegewezen_week = 0;
                    $bezet = 0;
                }

            } else {

                Session::flash('error', 'Er is een onbekende fout opgetreden, reservering afgebroken.');
                return redirect('/reservations/myreservations');
            }

            $reservation = App\Reservation::create([
                'user_id' => $user_id,
                'reservation_id' => $reservation_id,
                'location_id' => $request['location_id'],
                'res_week1' => $request['res_week1'],
                'res_week2' => $request['res_week2'],
                'res_week3' => $request['res_week1'],
                'res_year' => $request['res_year'],
                'res_status' => $res_status,
                'res_toegewezen_week' => $res_toegewezen_week,
                'res_ronde' => $res_ronde,
                'res_akkoord' => $request['res_akkoord'],
            ]);

            $payment = New payment([
                'payment_status' => 0,
                'payment_price' => 0.00,
                'payment_tax' => 0,
            ]);

            $touristtax = New Touristtax([
                'tax_status' => 0,
                'tax_price' => 0.00,
                'za_zo' => 0,
                'zo_ma' => 0,
                'ma_di' => 0,
                'di_wo' => 0,
                'wo_do' => 0,
                'do_vrij' => 0,
                'vrij_za' => 0,
                'persons' => 0,
            ]);

            App\User::where('id', $user_id)->update([
                'email' => encrypt($request['email']),
                'phone' => encrypt($request['phone']),
                'adress' => encrypt($request['adress']),
                'postcode' => encrypt($request['postcode']),
                'city' => encrypt($request['city']),
                // 'work_location' => encrypt($request['work_location']),
                // 'work_department' => encrypt($request['work_department']),
            ]);

            DB::table("occupied_weeks_$res_year")->where('location_id', $res_location_id)->where('week', $res_toegewezen_week)->update(['bezet' => $bezet]);
            $reservation->payment()->save($payment);
            $reservation->touristtax()->save($touristtax);

            $user = User::find($user_id);
            (new User)->forceFill([
                'id' => $user->id,
                'email' => Crypt::decrypt($user->email),
            ])->notify(New MadeReservation($reservation));


            return redirect('/reservations/myreservations');
        } 

    }

    public function destroy(Request $request) {

        $reservation_id = $request->reservation_id;
        $reservation = Reservation::findOrFail($reservation_id);
        $res_year = DB::table('options')->where('id', 1)->value('value');

        DB::table("occupied_weeks_$res_year")->where('week', $request->input('toegewezen'))->update(['bezet' => 0]);

        App\Reservation::where('id', $reservation_id)->update([
            'deleted' => 1,
            'res_status' => 3,
        ]);

        return redirect('reservations/myreservations');
    }

    public function cancel(Request $request) {
        
        $reservation_id = $request->reservation_id;
        $reservation = Reservation::findOrFail($reservation_id);
        $res_year = DB::table('options')->where('id', 1)->value('value');

        DB::table("occupied_weeks_$res_year")->where('week', $request->input('toegewezen'))->update(['bezet' => 0]);

        App\Reservation::where('id', $reservation_id)->update([
            'deleted' => 1,
            'res_status' => 2,
        ]);

        Session::flash('error', 'Reservering #'. $reservation_id .' is geannuleerd.');
        return redirect('reservations/myreservations');
    }

}
