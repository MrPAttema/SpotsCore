<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App;
use App\User;
use DB;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $users = App\User::orderBy('lastname')->paginate(25);
        // $users = decrypt($usersRaw);
        return view('admin.accounts', compact('users'));
    }
}
