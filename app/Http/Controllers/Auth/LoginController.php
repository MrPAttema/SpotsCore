<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\User;
use DB;

use Socialite;

class LoginController extends Controller
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function index() {

        $facebookauth = DB::table('options')->where('id', 15)->value('value');

        return view('auth.login', compact('facebookauth')); 

    }

    public function login(Request $request)
    {
        $this->validate($request, [
                'email'    => 'required',
                'password' => 'required',
            ]);
        
        //Store Email field Value
        $loginValue = $request->input('email');
        
        //Get Login Type
        $login_type = $this->getLoginType($loginValue);

        if ($login_type == 'email') {
            $loginValue = $loginValue;
        } 

        //Change request type based on user input
        $request->merge([
            $login_type => $loginValue
        ]);
        
        //Check Credentials and redirect
        if (Auth::attempt($request->only($login_type, 'password'))) {
            return redirect()->intended($this->redirectPath());
        } 
        return redirect()->back()->withInput()->withErrors([ 'email' => "Deze gegevens komen niet overeen met onze database." ]);
    } 

    public function getLoginType($loginValue) 
    {
        return filter_var($loginValue, FILTER_VALIDATE_EMAIL ) 
        ? 'email' 
        : ( (preg_match('%^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$%i', $loginValue))
        ? 'employee_id' 
        : 'employee_id' );
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            // $this->username() => 'required|string',
            // 'username' => 'required|string',
            'password' => 'required|string',
        ]);
    }


    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->fields([
            'name', 
            'id', 
            'first_name', 
            'last_name', 
            'email', 
            'avatar', 
            'location',
        ])->scopes([
            'email', 
            'user_location',
        ])->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();

        $user = Socialite::driver('facebook')->fields([
            'name', 
            'id', 
            'email', 
            'verified', 
            'first_name', 
            'last_name', 
            'location',
        ])->user();

        // OAuth Two Providers
        $token = $user->token;
        $refreshToken = $user->refreshToken;
        $expiresIn = $user->expiresIn;

        $authUser = $this->findOrCreateUser($user);
    
        Auth::login($authUser, true);

        return redirect('/home');
    }

    /**
     * If user does not exists then make Account.
     *
     * @return Response
     */
    private function findOrCreateUser($facebookUser)
    {
        $authUser = User::where('facebook_id', $facebookUser->id)->first();

        if ($authUser){

            return $authUser;

        }
        return User::create([
            'firstname' => $facebookUser->user["first_name"],
            'lastname' => $facebookUser->user["last_name"],
            'email' => $facebookUser->email,
            'email' => encrypt($facebookUser->email),
            'facebook_id' => $facebookUser->id,
            'avatar' => $facebookUser->avatar,
            // 'city' => $facebookUser->user["location"]["name"],
        ]);
    }

}
