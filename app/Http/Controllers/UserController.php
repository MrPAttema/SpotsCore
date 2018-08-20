<?php

namespace App\Http\Controllers;

use App;
use App\User;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;
use Illuminate\Contracts\Encryption\DecryptException;

class UserController extends Controller
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
        $user = App\User::where('id', $id)->get()->toArray();
        $user = array_shift($user);

        $priority = DB::table('priorities')->where('employee_id', $user['employee_id'])->get()->toArray();
        $priority = array_shift($priority);
        $count = 0;
        if(isset($priority)) {
            if (end($priority) === 'IN') {
                $count = 1;
            } else {            
                foreach ($priority as $priorityType) {
                    if ($priorityType === 'UIT') {
                        $count++;
                    } elseif (($priorityType === 'IN') || ($priorityType === '0')) {
                        $count = 0;
                    }
                }
            }
        }
        if ($count === 0) {
            $count++;
        }
        $priority = $count;

        return view('users.profile', compact('user', 'priority'));
    }

    public function update(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|same:email_herhalen',
            'phone' => 'required|digits_between:10,10|numeric',
            'adress' => 'required',
            'postcode' => 'required',
            'city' => 'required',
            'work_location' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('users/profile')
                ->withErrors($validator)
                ->withInput();
        }
            
        $currentUserID = Auth::id();

        App\User::where('id', $currentUserID)->update([
            'firstname' => Crypt::encrypt($request->firstname),
            'lastname' => Crypt::encrypt($request->lastname),
            'email' => Crypt::encrypt($request->email),
            'phone' => Crypt::encrypt($request->phone),
            'adress' => Crypt::encrypt($request->adress),
            'postcode' => Crypt::encrypt($request->postcode),
            'city' => Crypt::encrypt($request->city),
            'work_location' => Crypt::encrypt($request->work_location),
            'work_department' => Crypt::encrypt($request->work_department),
        ]);
            
        $request->session()->flash('message', 'Wijzigingen opgeslagen.');
        return redirect('users/profile');
    }
}
