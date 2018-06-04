<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Reservation;
use App\Payment;
use App\User;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use App\Notifications\PaymentFailed;

class PaymentFailedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PaymentFailedCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind users payment(s) have failed.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = Carbon::now();
        $currentWeek = $date->weekOfYear;
        $currentYear = $date->year;
        $reservations = Reservation::with('payment', 'user')->get();
        foreach ($reservations as $reservation){
            $user_id = $reservation->user_id;
            if ($reservation->payment->payment_status == 2) {
                $user = User::find($user_id);
                $user->notify(New PaymentFailed());
            }
        }
    }
}
