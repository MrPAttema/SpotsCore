<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DubbleCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $reservations = Reservation::with('user')->get();
        foreach ($reservations as $reservation){
            $user_id = $reservation->user_id;
            $reminderWeek = $reservation->res_toegewezen_week -3;
            if ($currentYear == ($reservation->res_year)) {
                if ($reservation->payment->payment_status == (0)) {
                    if ($currentWeek == ($reminderWeek)) {
                        $user = User::find($user_id);
                        $user->notify(New PaymentAdvanceReminder());
                    }
                }
            } 
        }
    }
}
