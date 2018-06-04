<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mollie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Touristtax;
use App\TouristtaxArchive;
use Carbon\Carbon;

class PaymentsController extends Controller
{
    public function __construct() {
        
      // $this->middleware('auth');
    }

    public function ReservationPayment(Request $request) {

        $user_id = Auth::id();
        $reservation_id = $request->reservation_id;
        $reservation = DB::table('reservations')->where('id', $reservation_id)->get();
        foreach ($reservation as $reservation) {
            $res_toegewezen_week = $reservation->res_toegewezen_week;
            $location_id = $reservation->location_id;
        }

        
        $location = DB::table('locations')->where('id', $location_id)->get();
        $found = false;
        foreach ($location as $location) {
            $weekNumbers = (explode(",", $location->location_date_high));
            foreach ($weekNumbers as $weekNumber) {
                if (strpos($res_toegewezen_week, $weekNumber) !== false ){
                    $found = true;
                }
            }
        }
        
        if (!$found) {

            $amount = DB::table('locations')->where('id', $location_id)->value('location_price');

        } else {

            $amount = DB::table('locations')->where('id', $location_id)->value('location_price_high');
            
        }

        $payment = Mollie::api()->payments()->create([
            "amount"      => $amount,
            "description" => "#$reservation_id - Huurbetaling",
            "redirectUrl" => "https://vvmcl.nl/reservations/myreservations",
            "webhookUrl" => "https://vvmcl.nl/mollie/reservation_webhook",
            'metadata'    => array(
                'reservation_id' => $reservation_id,
                'user_id' => $user_id,
                'is_archive' => 0,
            )
        ]);

      return redirect($payment->getPaymentUrl());
      exit;
    }

    public function TouristtaxPayment(Request $request) {

        $reservation_id = $request->reservation_id;
        $location_id = $request->location_id;
        $is_archive = $request->is_archive;
        $user_id = Auth::id();
        $amount = $request->totaal;
        $current_timestamp = date("Y-m-d H:i:s");

        if ($is_archive == 1) {

            $touristtax_archives = DB::table('touristtax_archives')->where('id', $reservation_id)->update([
                'tax_status' => 0,
                'tax_price' => $amount,
                'za_zo' => $request->input('za-zo'),
                'zo_ma' => $request->input('zo-ma'),
                'ma_di' => $request->input('ma-di'),
                'di_wo' => $request->input('di-wo'),
                'wo_do' => $request->input('wo-do'),
                'do_vrij' => $request->input('do-vrij'),
                'vrij_za' => $request->input('vrij-za'),
                'updated_at' => $current_timestamp,
            ]);

            $payment = Mollie::api()->payments()->create([

                "amount"      => $amount,
                "description" => "#$reservation_id - Touristenbelasting - Archief",
                "redirectUrl" => "https://vvmcl.nl/reservations/myreservations",
                "webhookUrl" => "https://vvmcl.nl/mollie/touristtax_webhook",
                'metadata'    => array(

                    'reservation_id' => $reservation_id,
                    'user_id' => $user_id,
                    'is_archive' => $is_archive,

                )
            ]);

            return redirect($payment->getPaymentUrl());

        } else {

             $touristtax = Touristtax::create([
                'reservation_id' => $reservation_id,
                'tax_status' => 0,
                'tax_price' => $amount,
                'za_zo' => $request->input('za-zo'),
                'zo_ma' => $request->input('zo-ma'),
                'ma_di' => $request->input('ma-di'),
                'di_wo' => $request->input('di-wo'),
                'wo_do' => $request->input('wo-do'),
                'do_vrij' => $request->input('do-vrij'),
                'vrij_za' => $request->input('vrij-za'),
            ]);

            $payment = Mollie::api()->payments()->create([

                "amount"      => $amount,
                "description" => "#$reservation_id - Touristenbelasting",
                "redirectUrl" => "https://vvmcl.nl/reservations/myreservations",
                "webhookUrl" => "https://vvmcl.nl/mollie/touristtax_webhook",
                'metadata'    => array(

                    'reservation_id' => $reservation_id,
                    'user_id' => $user_id,
                    'is_archive' => 0,

                )
            ]);

            return redirect($payment->getPaymentUrl());

        }

    }

    public function TouristtaxPaymentArchive(Request $request) {
        
        $reservation_id = $request->reservation_id;
        $location_id = $request->location_id;
        $user_id = Auth::id();
        $amount = $request->totaal;

        $touristtax = TouristtaxArchive::where('')->update([
            'reservation_id' => $reservation_id,
            'tax_status' => 0,
            'tax_price' => $amount,
            'za_zo' => $request->input('za-zo'),
            'zo_ma' => $request->input('zo-ma'),
            'ma_di' => $request->input('ma-di'),
            'di_wo' => $request->input('di-wo'),
            'wo_do' => $request->input('wo-do'),
            'do_vrij' => $request->input('do-vrij'),
            'vrij_za' => $request->input('vrij-za'),
        ]);

        $payment = Mollie::api()->payments()->create([

            "amount"      => $amount,
            "description" => "#$reservation_id - Touristenbelasting",
            "redirectUrl" => "https://vvmcl.nl/reservations/myreservations",
            "webhookUrl" => "https://vvmcl.nl/mollie/touristtax_webhook",
            'metadata'    => array(

                'reservation_id' => $reservation_id,
                'user_id' => $user_id,

            )
        ]);

        return redirect($payment->getPaymentUrl());

    }
}
