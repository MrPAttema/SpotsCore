<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Reservation;
use App\Touristtax;
use App\User;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use App\Notifications\TaxReminder;

class TaxReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TaxReminderCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind users to pay there touristtax.';

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
        $reservations = Reservation::with('touristtax', 'user')->get();
        foreach ($reservations as $reservation){
            $user_id = $reservation->user_id;
            if ($currentYear == $reservation->res_year) {
                if (($reservation->res_status == 1) && ($reservation->touristtax->tax_status == 0)) {
                    if (($currentWeek > $reservation->res_toegewezen_week) && ($reservation->res_toegewezen_week > 0)) {
                        $user = User::find($user_id);
                        $user->notify(New TaxReminder($reservation));
                    }
                }
            }
        }
    }
}