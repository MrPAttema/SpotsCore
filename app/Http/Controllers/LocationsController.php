<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LocationsController extends Controller
{
    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function __construct() {

        $this->middleware('auth');
    }

    public function index() {

        $locations = DB::table('locations')->get();
        return view('user.index', ['users' => $users]);
    }

    public function updateSettings() {

        

    }
}
