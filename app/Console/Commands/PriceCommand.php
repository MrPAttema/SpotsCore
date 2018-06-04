<?php

namespace App\Console\Commands;

use DB;
use App;
use App\Location;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PriceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PriceCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check every day if prices are correct.';

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
        $currentWeekNumber = $date->weekOfYear;
        $currentDayNumber = $date->dayOfWeek;
        $locations = Location::get();
        foreach ($locations as $location) {
            $locationID = $location->id;
            $weekNumbers = (explode(",",$location->location_date_high));
            foreach ($weekNumbers as $weeknumber) {
                if ($weekNumbers == $currentWeekNumber) {
                    DB::table('locations')->where('id', $locationID)->update(['location_price_high_active' => 1]);
                } else {
                    DB::table('locations')->where('id', $locationID)->update(['location_price_high_active' => 0]);
                }
            }
        }
    }
}
