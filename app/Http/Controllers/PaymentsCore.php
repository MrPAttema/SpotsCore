<?php

/**
* New payment core.
*
* @year 2018
* @author Patrick Attema
*/

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Touristtax;
use App\TouristtaxArchive;
use App\Payment;
use App\PaymentArchive;
use App\Reservation;
use App\ReservationArchive;
use App\Location;
use App\LocationArchive;

use Mollie;

class PaymentsCore extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
         $this->middleware('auth');
    }

    protected function checkPayment(Request $request) {

        $currentUserId = Auth::id();

        $paymentData = array();

        $paymentData = $request->all();

        dd($paymentData);
        
        $checkData = Reservation::where('id', $paymentData['reservation_id'])->get();  

        foreach ($checkData as $checkData) {

            if ($checkData->user_id == $currentUserId) {   

                $locationData = Location::where('id', $checkData->location_id)->get();

                if (isset($paymentData["amount"])) {

                    $paymentData["amount"] = $paymentData["amount"];
                }

                $paymentData["webhookUrl"] = "https://vvmcl.nl/mollie/webhook";
                $paymentData["redirectUrl"] = "https://vvmcl.nl/reservations/myreservations";

                return $this->typePayment($paymentData);

            } else {

        } 

            $request->session()->flash('error', 'Incorrecte reserverings ID.');
            return redirect('/reservations/myreservations');
        }
    }

    protected function typePayment($paymentData) {

        switch ($paymentData['type_id']) {

            case '1':
                $metaData = array();

                $paymentData['description'] = "#" . $paymentData['reservation_id'] . " - Huurbetaling";
                $metaData["reservation_id"] = $paymentData['reservation_id'];
                $metaData["type_id"] = "1";

                break;

            case '2':
                $metaData = array();

                $paymentData['description'] = "#" . $paymentData['reservation_id'] . " - Toeristenbelasting";
                $metaData["reservation_id"] = $paymentData['reservation_id'];
                $metaData["type_id"] = "2";
                break;

            case '3':
                $metaData = array();

                $paymentData['description'] = "#" . $paymentData['reservation_id'] . " - Toeristenbelasting - Archief";
                $metaData["reservation_id"] = $paymentData['reservation_id'];
                $metaData["type_id"] = "3";
                break;

            case '4':
                $metaData = array();

                $paymentData['description'] = "#" . $paymentData['reservation_id'] . " - Toeristenbelasting - Archief";
                $metaData["reservation_id"] = $paymentData['reservation_id'];
                $metaData["type_id"] = "4";
                break;
            
            default:
                $request->session()->flash('error', 'Incorrecte betalingstype.');
                return redirect('/reservations/myreservations');
                break;
        }
                
        return $this->createPayment($paymentData, $metaData);

    }

    protected function createPayment($paymentData, $metaData) {

        $payment = Mollie::api()->payments()->create([
            'amount'      => $paymentData['amount'],
            'description' => $paymentData['description'],
            'redirectUrl' => $paymentData['redirectUrl'],
            'webhookUrl' => $paymentData['webhookUrl'],
            'metadata'    => array(
                $metaData,
            )
        ]);

        $this->processPayment($paymentData);

        return redirect($payment->getPaymentUrl());
    }

    protected function processPayment($paymentData) {

        if ($paymentData['type_id'] == 2) {

            $touristtax = Touristtax::create([
                'reservation_id' => $paymentData['reservation_id'],
                'tax_status' => 0,
                'tax_price' => $paymentData['amount'],
                'za_zo' => $paymentData['za-zo'],
                'zo_ma' => $paymentData['zo-ma'],
                'ma_di' => $paymentData['ma-di'],
                'di_wo' => $paymentData['di-wo'],
                'wo_do' => $paymentData['wo-do'],
                'do_vrij' => $paymentData['do-vrij'],
                'vrij_za' => $paymentData['vrij-za'],
            ]);

        } elseif ($paymentData['type_id'] == 3) {

            $touristtax_archives = DB::table('touristtax_archives')->where('id', $reservation_id)->update([
                'tax_status' => 0,
                'tax_price' => $amount,
                'za_zo' => $paymentData['za-zo'],
                'zo_ma' => $paymentData['zo-ma'],
                'ma_di' => $paymentData['ma-di'],
                'di_wo' => $paymentData['di-wo'],
                'wo_do' => $paymentData['wo-do'],
                'do_vrij' => $paymentData['do-vrij'],
                'vrij_za' => $paymentData['vrij-za'],
                'updated_at' => $current_timestamp,
            ]);
        } 
        
        return true;  
    }
}