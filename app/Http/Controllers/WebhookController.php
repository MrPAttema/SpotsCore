<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\Notifiable;
use App\Notifications\ReservationPaid;
use App\Notifications\TouristtaxPaid;
use Illuminate\Http\Request;
use Mollie;
use DB;
use App\User;
use App\Payment;
use App\Touristtax;

class WebhookController extends Controller
{
  public function __construct()
    {
        //$this->middleware('auth');
    }

  public function reservation_paid(Request $request)
    {
        $current_timestamp = date("Y-m-d H:i:s");
        $payment = Mollie::api()->payments()->get($request->id);
        $reservation_id = $payment->metadata->reservation_id;
        $user_id = $payment->metadata->user_id;
        $mollie_id = $payment->id;

        if ($payment->isPaid())
        {
            Payment::where('reservation_id', $reservation_id)->update([

                'payment_status' => 1,
                'payment_time' => $current_timestamp,

            ]);

            $user = User::find($user_id);
            $user->notify(new ReservationPaid($payment));
        }

        elseif (! $payment->isOpen()) {

            DB::table('payments')->where('reservation_id', $reservation_id)->update(['payment_status', 2]);

        }
    }

    public function touristtax_paid(Request $request)
      {
        $current_timestamp = date("Y-m-d H:i:s");
        $payment = Mollie::api()->payments()->get($request->id);
        $reservation_id = $payment->metadata->reservation_id;
        $is_archive = $payment->metadata->is_archive;
        $user_id = $payment->metadata->user_id;

        if ($is_archive == 1) {

            if ($payment->isPaid())
            {
                DB::table('touristtax_archives')->where('id', $reservation_id)->update([

                    'tax_status' => 1,
                    'updated_at' => $current_timestamp,

                ]);

                $user = User::find($user_id);
                $user->notify(new TouristtaxPaid($payment));
            }
            
            elseif (! $payment->isOpen()) {

                DB::table('touristtaxes')->where('reservation_id', $reservation_id)->update(['status', 2]);

            }

        } elseif ($is_archive == 0) {

            if ($payment->isPaid())
            {
                Touristtax::where('reservation_id', $reservation_id)->update([

                    'tax_status' => 1,
                    'updated_at' => $current_timestamp,

                ]);

                $user = User::find($user_id);
                $user->notify(new TouristtaxPaid($payment));
            }
            
            elseif (! $payment->isOpen()) {

                DB::table('touristtaxes')->where('reservation_id', $reservation_id)->update(['status', 2]);

            }
        } 
    }
}
