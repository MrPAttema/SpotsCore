<?php

namespace App\Http\Controllers;

use App;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Session;

class UserSettingsController extends Controller
{
    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = Auth::id();
        $users = App\User::where('id', $id)->get();
        $saveloginhistory = DB::table('options')->where('id', 16)->value('value');
        return view('users.settings', compact('users', 'saveloginhistory'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'newPassword' => 'required|min:12',
            'newPassword_confirmation' => 'required|confirmed',
            ])->validate();
            
        $currentUserID = Auth::id();

        App\User::where('id', $currentUserID)->update([
          'password' => hash($request['newPassword']),
        ]);

        $request->session()->flash('message', 'Uw wachtwoord is gewijzigd.');
        return Redirect('users/settings');
    }
}
