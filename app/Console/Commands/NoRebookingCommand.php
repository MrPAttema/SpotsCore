<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NoRebookingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'NoRebookingCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'If a user cancels, and the week does not get rebooked. The first user needs to pay 50% of the original bookingcost.';

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
            $reminderWeek = $reservation->res_toegewezen_week -6;
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
