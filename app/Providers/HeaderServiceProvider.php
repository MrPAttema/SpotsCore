<?php 

namespace App\Providers;

use DB;
use App;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class HeaderServiceProvider extends ServiceProvider {

    public function boot() {
        
        View::composer('layouts.app', function ($view) {
            
            $currentUserID = Auth::id();

            $messages = DB::table('notifications')->where('notifiable_id', $currentUserID)->where('read_at', NULL)->get();

            $messageCount = 0;

            foreach ($messages as $message) {
                $messageCount ++;
            }

            $view->with('messageCount', $messageCount);
        });
    }


    public function register()
    {
        //
    }
}