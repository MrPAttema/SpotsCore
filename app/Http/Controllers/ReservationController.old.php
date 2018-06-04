<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Reservation;
use App\User;
use App\Payment;
use App\Touristtax;
use App\Notifications\MadeReservation;
use App\Notifications\ReservationAssign;
use DB;
use Session;

class ReservationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $ronde1 = DB::table('options')->where('id', 3)->value('value');
        $ronde2 = DB::table('options')->where('id', 4)->value('value');

        if ($ronde1 == 1) {

            $location_id = $request->input('location_id');
            $location = DB::table('locations')->where('id', 1)->get();
            $boekingsjaar = DB::table('options')->where('id', 1)->value('value');
            $boekingsjaarOld = $boekingsjaar-1;
            $autotoewijzen = DB::table('options')->where('id', 2)->value('value');

            return view('reservations.new', compact('makereservations', 'boekingsjaar', 'boekingsjaarOld', 'location', 'autotoewijzen'));

        } elseif ($ronde2 == 1) {

            $location_id = $request->input('location_id');
            $location = DB::table('locations')->where('id', 1)->get();
            $boekingsjaar = DB::table('options')->where('id', 1)->value('value');
            $boekingsjaarOld = $boekingsjaar-1;
            $autotoewijzen = DB::table('options')->where('id', 2)->value('value');

            return view('reservations.new', compact('makereservations', 'boekingsjaar', 'boekingsjaarOld', 'location', 'autotoewijzen'));

        } else {

            $request->session()->flash('error', 'Reserveren is niet mogelijk. Probeer het later nog een keer.');
            return redirect('accommodations/all');

        }      
    }


    public function steptwo(Request $request)
    {
        $ronde1 = DB::table('options')->where('id', 3)->value('value');
        $ronde2 = DB::table('options')->where('id', 4)->value('value');

        if ($ronde1 == 1) {

            $boekingsjaar = $request->input('res_year');
            $location_id = $request->input('location_id');
            $location = DB::table('locations')->where('id', 1)->get();
    
            $ronde2 = DB::table('options')->where('id', 4)->value('value');
            $occupied_weeks = DB::table("occupied_weeks_$boekingsjaar")->where('bezet', 0)->get();
    
            return view('reservations.new_steptwo', compact('occupied_weeks', 'makereservations', 'boekingsjaar', 'location', 'ronde2'));

        } elseif ($ronde2 == 1) {

            $boekingsjaar = $request->input('res_year');
            $location_id = $request->input('location_id');
            $location = DB::table('locations')->where('id', 1)->get();

            $ronde2 = DB::table('options')->where('id', 4)->value('value');
            $occupied_weeks = DB::table("occupied_weeks_$boekingsjaar")->where('bezet', 0)->get();

        return view('reservations.new_steptwo', compact('occupied_weeks', 'makereservations', 'boekingsjaar', 'location', 'ronde2'));

        } else {

            $request->session()->flash('error', 'Reserveren is niet mogelijk. Probeer het later nog een keer.');
            return redirect('accommodations/all');

        }     
    }

    public function store(Request $request) {
        
        // $request->validate([
        //     'res_year' => 'required',
        //     'res_week1' => 'required',
        //     'res_week2' => 'required',
        //     'res_akkoord' => 'required',
        // ]);

        $user_id = Auth::id();
        $user = User::find($user_id);      
        $current_timestamp = date("Y-m-d H:i:s");
        $boekingsjaar = $request->input('res_year');
        $autotoewijzen = DB::table('options')->where('id', 2)->value('value');
        $ronde1 = DB::table('options')->where('id', 3)->value('value');
        $ronde2 = DB::table('options')->where('id', 4)->value('value');
        $dubbeleboekingen = DB::table('options')->where('id', 5)->value('value'); 
        $worklocation = DB::table('users')->where('id', $user_id)->value('work_location');
        $boekingsjaar = DB::table('options')->where('id', 1)->value('value');
        $week = DB::table("occupied_weeks_$boekingsjaar")->where('week', $request->weekOne)->value('bezet');

        if ($ronde1 == 1) {

            $reservation = Reservation::create([
                'user_id' => $user_id,
                'location_id' => $request->input('location_id'),
                'res_week1' => $request->weekOne,
                'res_week2' => $request->weekTwo,
                'res_year' => $request->input('boekingsjaar'),
                'res_status' => 0,
                'res_toegewezen_week' => 0,
                'res_ronde' => 1,
                'res_akkoord' => $request->input('res_akkoord'),
                ]);

            App\User::where('id', $user_id)->update([
                'phone' => $request->input('phone'),
                'adress' => $request->input('adress'),
                'postcode' => $request->input('postcode'),
                'city' => $request->input('city'),
                'work_location' => $request->input('work_location'),
                'work_department' => $request->input('work_department'),
            ]);

            $payment = New Payment([
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

            $reservation->payment()->save($payment);
            $reservation->touristtax()->save($touristtax);
            $user = User::find($user_id);
            $user->notify(New MadeReservation($reservation));
            return redirect('/reservations/myreservations');

        } elseif ($ronde2 == 1) {

            if ($week == 1) {

                Session::flash('error', 'Week '. $request->weekOne .' is al uitgegeven. Onze excuuses voor het ongemak.');
                return redirect('/accommodations/all'); 

            } else {       

                if (($worklocation == "GeenZPF") || ($worklocation == "Geen ZPF")) {

                    $reservation = Reservation::create([
                        'user_id' => $user_id,
                        'location_id' => $request->input('location_id'),
                        'res_week1' => 0,
                        'res_week2' => 0,
                        'res_week3' => $request->weekOne,
                        'res_year' => $request->input('boekingsjaar'),
                        'res_status' => 0,
                        'res_toegewezen_week' => 0,
                        'res_ronde' => 2,
                        'res_akkoord' => $request->input('res_akkoord'),
                    ]);

                    App\User::where('id', $user_id)->update([
                        'phone' => $request->input('phone'),
                        'adress' => $request->input('adress'),
                        'postcode' => $request->input('postcode'),
                        'city' => $request->input('city'),
                        'work_location' => $request->input('work_location'),
                        'work_department' => $request->input('work_department'),
                    ]);

                    $payment = New Payment([
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

                    $reservation->payment()->save($payment);
                    $reservation->touristtax()->save($touristtax);
                    $user = User::find($user_id);
                    $user->notify(New MadeReservation($reservation));
                    return redirect('/reservations/myreservations');

                } else {

                     if (($dubbeleboekingen == 1) && ($autotoewijzen == 1)) {
                        
                        DB::table("occupied_weeks_$boekingsjaar")->where('week', $request->weekOne)->update(['bezet' => 1]);

                        $reservation = Reservation::create([
                            'user_id' => $user_id,
                            'location_id' => $request->input('location_id'),
                            'res_week1' => 0,
                            'res_week2' => 0,
                            'res_week3' => $request->weekOne,
                            'res_year' => $request->input('boekingsjaar'),
                            'res_status' => 1,
                            'res_toegewezen_week' => $request->weekOne,
                            'res_ronde' => 2,
                            'res_akkoord' => $request->input('res_akkoord'),
                        ]);

                        App\User::where('id', $user_id)->update([
                            'phone' => $request->input('phone'),
                            'adress' => $request->input('adress'),
                            'postcode' => $request->input('postcode'),
                            'city' => $request->input('city'),
                            'work_location' => $request->input('work_location'),
                            'work_department' => $request->input('work_department'),
                        ]);

                        $payment = New Payment([
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

                        $reservation->payment()->save($payment);
                        $reservation->touristtax()->save($touristtax);
                        $user = User::find($user_id);
                        $user->notify(New MadeReservation($reservation));
                        return redirect('/reservations/myreservations');

                    } else {

                        $dubbelcheck = DB::table('reservations')->where('user_id', $user_id)->where('res_year', $boekingsjaar)->where('res_status', 1)->get();

                        if (!empty($dubbelcheck)) {

                            $reservation = Reservation::create([
                                'user_id' => $user_id,
                                'location_id' => $request->input('location_id'),
                                'res_week1' => 0,
                                'res_week2' => 0,
                                'res_week3' => $request->weekOne,
                                'res_year' => $request->input('boekingsjaar'),
                                'res_status' => 0,
                                'res_toegewezen_week' => 0,
                                'res_ronde' => 2,
                                'res_akkoord' => $request->input('res_akkoord'),
                            ]);

                            App\User::where('id', $user_id)->update([
                                'phone' => $request->input('phone'),
                                'adress' => $request->input('adress'),
                                'postcode' => $request->input('postcode'),
                                'city' => $request->input('city'),
                                'work_location' => $request->input('work_location'),
                                'work_department' => $request->input('work_department'),
                            ]);

                            $payment = New Payment([
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

                            $reservation->payment()->save($payment);
                            $reservation->touristtax()->save($touristtax);
                            $user = User::find($user_id);
                            $user->notify(New MadeReservation($reservation));
                            Session::flash('info', 'Uw reservering is in goede orde ontvangen, wel is dit uw tweede voor het jaar '. $request->input('boekingsjaar').', daarom moet u wachten op een toewijzing.');
                            return redirect('/reservations/myreservations');

                        }                    
                    }
                }    
            } 
        }      
    }

    public function destroy(Request $request) {

        $reservation_id = $request->reservation_id;
        $reservation = Reservation::findOrFail($reservation_id);
        $boekingsjaar = DB::table('options')->where('id', 1)->value('value');

        DB::table("occupied_weeks_$boekingsjaar")->where('week', $request->input('toegewezen'))->update(['bezet' => 0]);

        App\Reservation::where('id', $reservation_id)->update([
            'deleted' => 1,
            'res_status' => 2,
        ]);

        return redirect('reservations/myreservations');
    }

    public function cancel(Request $request) {
        
        $reservation_id = $request->reservation_id;
        $reservation = Reservation::findOrFail($reservation_id);
        $boekingsjaar = DB::table('options')->where('id', 1)->value('value');

        DB::table("occupied_weeks_$boekingsjaar")->where('week', $request->input('toegewezen'))->update(['bezet' => 0]);

        App\Reservation::where('id', $reservation_id)->update([
            'deleted' => 1,
            'res_status' => 3,
        ]);

        Session::flash('error', 'Reservering #'. $reservation_id .' is geannuleerd.');
        return redirect('reservations/myreservations');
    }

}
