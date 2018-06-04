<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App;
use App\User;

class PrivacyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $id = Auth::id();
        $users = App\User::where('id', $id)->get();
        return view('users.privacy', compact('users'));
    }
}
