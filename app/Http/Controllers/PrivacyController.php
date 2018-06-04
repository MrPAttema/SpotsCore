<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use DB;

class PrivacyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $currentUserID = Auth::id();
        $logs = DB::table('logging')->where('user_id', $currentUserID)->orderBy('created_at', 'desc')->paginate(10);
        // foreach ($logs as $log) {
        //     dd($log);
        //     if ($log->platform == "Windows 10") {
        //         $log->platform = 1;
        //     } elseif ($log->platform == "Android") {
        //         $log->platform = 2;
        //     }
        // }
        return view('users.privacy', compact('logs'));
    }
}
