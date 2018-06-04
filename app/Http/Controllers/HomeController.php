<?php

namespace App\Http\Controllers;

use DB;
use App;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ipLogging');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();

        $reservation = App\Reservation::with('location')->where('user_id', $id)->orderBy('id', 'desc')->first();

        return view('home', compact('reservation'));

    }
}
