<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Reservation;
use App\Payment;
use App\User;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use App\Notifications\PaymentAdvanceReminder;

class PaymentAdvanceReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PaymentAdvanceReminderCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind users who havent paid rent, to do before leave.';

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
            $reminderWeek = $reservation->res_toegewezen_week -3;
            if ($currentYear == ($reservation->res_year)) {
                if (($reservation->res_status == 1) && ($reservation->payment->payment_status == 0)) {              
                    if ($currentWeek == ($reminderWeek) && ($reservation->res_toegewezen_week > 0)) {
                        dump($reservation->res_toegewezen_week);
                        $user = User::find($user_id);
                        $user->notify(New PaymentAdvanceReminder($reservation));
                    }
                }
            }
        }
    }
}
