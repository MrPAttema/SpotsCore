<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use DB;
use App;
use App\User;

class InboxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $currentUserID = Auth::id();
        $currentUser = App\User::find($currentUserID);

        $notification = DB::table('notifications')->where('notifiable_id', $currentUserID)->where('type', 'App\Notifications\MadeReservation')->get();
        
        $notifications = $notification->map(function($notification){
            return [
                'id' => $notification->id,
                'data' => json_decode($notification->data, true),
                'created_at' => $notification->created_at,
                'read_at' => $notification->read_at
            ];
        });

        return view('users.inbox', compact('users', 'notifications'));
    }

    public function markAsRead(Request $request)
    {
        DB::table('notifications')->where('id', $request['notification_id'])->update(['read_at' => now()]);

        return redirect('/users/inbox');
    }
}
