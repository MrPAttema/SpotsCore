<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;

class OpenAndCloseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'OpenAndCloseCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if reservation rounds are to open or to close.';

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
        $datetime = Carbon::now();
        $openYear = DB::table('options')->where('name', 'openyear')->value('value');
        $closeYear = DB::table('options')->where('name', 'closeyear')->value('value');

        if ($datetime >= ($openYear)) {

            DB::table('options')->where('name', 'ronde1')->update(['value' => 1]);  
            
        } 
        if ($datetime >= ($closeYear)) {
            
            DB::table('options')->where('name', 'ronde1')->update(['value' => 0]);
            DB::table('options')->where('name', 'ronde2')->update(['value' => 0]);

        }
    }
}
