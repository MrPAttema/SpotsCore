<?php

namespace App\Http\Controllers;

use App;
use App\User;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function __construct()
  	{
	  	// $this->middleware('auth:admin');
    }
      
    public function selectSearch(Request $request, Reservations $reservations) {

        dd($request);
        
        // $searchValue = $request->searchValue;

        $reservations = $reservations->newQuery();

        // Search for a user based on their name.
        if ($request->has('open')) {
            $reservations->where('open', $request->input('open'));
        }

        // Search for a reservations based on their company.
        if ($request->has('paid')) {
            $reservations->where('paid', $request->input('paid'));
        }

        // // Search for a reservations based on their city.
        // if ($request->has('city')) {
        //     $reservations->where('city', $request->input('city'));
        // }

        // Continue for all of the filters.
        dd($reservations);
        // Get the results and return them.
        return $reservations->get();
        
        switch ($searchValue) {
            case 'open':
                # code...
                break;

            case 'paid':
                # code...
                break;

            case 'unpaid':
                # code...
                break;

            case 'assigned':
                # code...
                break;

            case 'rejected':
                # code...
                break;
            
            default:
                
                break;

            return $this->searchAdminReservations($searchValue);
        }
    }

    public function inputSearch(Request $request, Reservation $reservation)
	{  		
        $searchData = $request->all();
        
		$reservations = App\Reservation::with('payment', 'touristtax', 'user')
        ->where('res_year', 'LIKE', $searchData['keyword'])
        ->where('deleted', '==' ,'NULL')
        ->orWhere('id', 'LIKE', $searchData['keyword'])
        ->orWhere('res_week1', 'LIKE', $searchData['keyword'])
        ->orWhere('res_week2', 'LIKE', $searchData['keyword'])
        ->orWhere('res_week3', 'LIKE', $searchData['keyword'])
        ->orWhere('res_toegewezen_week', 'LIKE', $searchData['keyword'])
        ->orWhere('user_id', 'LIKE', $searchData['keyword'])
        ->paginate(20);

        return view('admin.allreservations', compact('reservations'));
    }

    public function searchUserReservations($searchValue)
	{  
        $currentUserId = Auth::id();
		
		$result = App\Reservation::with('payment', 'touristtax')
        ->where('res_year', 'LIKE', $searchValue)
        ->where('user_id', '==', $currentUserId)
        ->where('deleted', '==' ,'NULL')
        ->orWhere('id', 'LIKE', $searchValue)
        ->orWhere('res_week1', 'LIKE', $searchValue)
        ->orWhere('res_week2', 'LIKE', $searchValue)
        ->orWhere('res_toegewezen_week', 'LIKE', $searchValue)
        ->orWhere('user_id', 'LIKE', $searchValue)
        ->get();

        return view('allreservations', compact('reservations'));
    }

  	public function searchAdminReservations()
	{  
		
		$result = App\Reservation::with('payment', 'touristtax')
        ->where('res_year', 'LIKE', $keyword)
        ->where('deleted', '==' ,'NULL')
        ->orWhere('id', 'LIKE', $keyword)
        ->orWhere('res_week1', 'LIKE', $keyword)
        ->orWhere('res_week2', 'LIKE', $keyword)
        ->orWhere('res_toegewezen_week', 'LIKE', $keyword)
        ->orWhere('user_id', 'LIKE', $keyword)
        ->get();

        return view('admin.allreservations', compact('reservations'));
    }    
    
}