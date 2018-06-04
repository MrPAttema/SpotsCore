<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

class InactiveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'InactiveCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set user inactive after a set period.';

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
        $lastYear = $data->subYear(2);
        $users = DB::table('users')->get();

        foreach ($users as $user) {

            $user_id = $user->id;

            if ($user->updated_at >= $lastYear) {
                $users = DB::table('user')->update([
                    'inactive' => 1
                ]); 
            }
        }
    }
}
