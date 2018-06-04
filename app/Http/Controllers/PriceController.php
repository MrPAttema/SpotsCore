<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function getWeekPrice(Request $request) {


        $requestData = $request->all();

        return $requestData['resWeekOne']; exit;

        $weekNumbers = array();
        
        $currentDateTime = Carbon::now();
        $currentWeek = $currentDateTime->weekOfYear;
        $requestData = $request->all();

        $res_year = $requestData['res_year'];
        $location_id = $requestData['location_id'];
        $location = DB::table('locations')->where('id', $location_id)->get();
        foreach ($location as $location) { 
        }
        $locationDates = explode(",", $location->location_date_high);
        $occupiedWeeks = DB::table('occupied_weeks_' . $res_year)->where('bezet', 0)->get();
        $weekNumbers = $locationDates;           
        
        $amount_low = DB::table('locations')->where('id', $location_id)->value('location_price');
        $amount_high = DB::table('locations')->where('id', $location_id)->value('location_price_high');

        $request->session()->flash('error', 'Reserveren is niet mogelijk. Probeer het later nog een keer.');
        return redirect('accommodations/all');

    }     
}
