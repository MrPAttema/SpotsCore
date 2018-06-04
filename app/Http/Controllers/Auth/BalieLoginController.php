<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Balie;

use Socialite;

class BalieLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/balie';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:balie')->except('logout');
    }

    public function index() {

        return view('auth.balielogin');
    }

    public function login(Request $request) {
        
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);


        if (Auth::guard('balie')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

            return redirect('/balie');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout() {

        Auth::guard('balie')->logout();
        return redirect('/');
    }
}
