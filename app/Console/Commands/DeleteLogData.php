<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Loggings;

class DeleteLogData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeleteLogData';

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
        $logs = Loggings::get();
        dd($logs);
		// foreach ($reservations as $reservation){    
		// 	$user_id = $reservation->user_id;
        //     $reminderWeek = $reservation->res_toegewezen_week +2;
		// 	if ($currentYear == $reservation->res_year) {
        //         if ($reservation->res_status == 1) {
        //             if ($reservation->touristtax->tax_status == 0) {
        //                 if ($currentWeek >= ($reminderWeek) && ($reservation->res_toegewezen_week > 0)) {
        //                     $user = User::find($user_id);
        //                     $user->notify(New PaymentWarning());
        //                 }
        //             }
        //         }
		// 	}
		// }
    }
}
