<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use DB;
use App\Location;

class AdminLocationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $locations = App\Location::get();
        $boekingsjaar = DB::table('options')->where('id', 1)->value('value');
        $autotoewijzen = DB::table('options')->where('id', 2)->value('value');
        $ronde1 = DB::table('options')->where('id', 3)->value('value');
        $ronde2 = DB::table('options')->where('id', 4)->value('value');   
        $dubbeleboekingen = DB::table('options')->where('id', 5)->value('value');
        $occupiedWeeks = DB::table("occupied_weeks_$boekingsjaar")->get();

        // dd($locations);
        return view('admin.locations.options', compact('locations', 'boekingsjaar', 'occupiedWeeks'));

    }

    public function update(Request $request)
    {
        # code...
    }

}
