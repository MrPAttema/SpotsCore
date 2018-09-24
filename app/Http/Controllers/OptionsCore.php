<?php

/**
* New options core.
* This core will implement all the framework options.
*
* @year 2018
* @author Patrick Attema
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use App\Options;
use DB;
use App\User;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class OptionsCore extends Controller
{
  public function __construct()
  {
      $this->middleware('auth:admin');
  }

    public function index() {

        $boekingsjaar = DB::table('options')->where('id', 1)->value('value');
        $autotoewijzen = DB::table('options')->where('id', 2)->value('value');
        $ronde1 = DB::table('options')->where('id', 3)->value('value');
        $ronde2 = DB::table('options')->where('id', 4)->value('value');   
        $dubbeleboekingen = DB::table('options')->where('id', 5)->value('value');
        $incltouristtax = DB::table('options')->where('id', 14)->value('value');
        $facebookauth = DB::table('options')->where('id', 15)->value('value');
        $taxtype = DB::table('options')->where('id', 16)->value('value');
        $reservations = DB::table('reservations')->orderBy('created_at', 'desc')->first();
        $occupied_weeks = DB::table("occupied_weeks")->get();
        $autoarchive = 1;

        return view('admin.options', compact(
            'reservations',
            'options',
            'boekingsjaar',
            'ronde1',
            'ronde2',
            'autotoewijzen',
            'dubbeleboekingen',
            'occupied_weeks',
            'autoarchive',
            'facebookauth',
            'incltouristtax',
            'taxtype'
        ));
    }

    public function updateSettings(Request $request) {
      
        $optionsData = $request->all();
       
        $ronde1 = (isset($optionsData['ronde1'])) ? 1 : 0;
        $ronde2 = (isset($optionsData['ronde2'])) ? 1 : 0;
        $autotoewijzen = (isset($optionsData['autotoewijzen'])) ? 1 : 0;
        $dubbeleboekingen = (isset($optionsData['dubbeleboekingen'])) ? 1 : 0;
        $autoarchive = (isset($optionsData['autoarchive'])) ? 1 : 0;
        $facebookauth = (isset($optionsData['facebookauth'])) ? 1 : 0;
        $incltouristtax = (isset($optionsData['incltouristtax'])) ? 1 : 0;
        $taxtype = (isset($optionsData['taxtype'])) ? 1 : 0;
               
        DB::table('options')->where('id', 3)->update(['value' => $ronde1]);
        DB::table('options')->where('id', 4)->update(['value' => $ronde2]);
        DB::table('options')->where('id', 2)->update(['value' => $autotoewijzen]);
        DB::table('options')->where('id', 5)->update(['value' => $dubbeleboekingen]);
        DB::table('options')->where('id', 6)->update(['value' => $autoarchive]);
        DB::table('options')->where('id', 14)->update(['value' => $incltouristtax]);
        DB::table('options')->where('id', 15)->update(['value' => $facebookauth]);
        DB::table('options')->where('id', 16)->update(['value' => $taxtype]);


        $request->session()->flash('message', 'Instellingen zijn opgeslagen.');
        return redirect('/admin/options');
    }

    public function newyear(Request $request) {

        $jaar = $request->input('year');

        $onderhoudweek = $request->onderhoudweek;

        $date = Carbon::createFromDate($jaar, 1, 1, 'Europe/Amsterdam');
        $end_date = $date->endOfYear();
        $max_weeks = $date->isoWeeksInYear();

        DB::statement("CREATE TABLE occupied_weeks_$jaar LIKE occupied_weeks");
        DB::insert(DB::raw("INSERT INTO occupied_weeks_$jaar SELECT * FROM occupied_weeks GROUP BY ID"));

        if ($max_weeks == 52){

            DB::table("occupied_weeks_$jaar")->where('week', 53)->update(['bezet' => 1]);

        }

        DB::table('options')->where('id', 1)->update(['value' => $jaar]);
        $request->session()->flash('message', 'Nieuw boekingsjaar aangemaakt.');

        return redirect('/admin/options');
    } 

    public function autoArchive(Request $request) {

        $jaar = $request->input('year');

        $onderhoudweek = $request->onderhoudweek;

        $date = Carbon::createFromDate($jaar, 1, 1, 'Europe/Amsterdam');
        $end_date = $date->endOfYear();
        $max_weeks = $end_date->subDays(3);
        $weeks_total = ($max_weeks->weekOfYear);

        DB::statement("CREATE TABLE occupied_weeks_$jaar LIKE occupied_weeks");
        DB::insert(DB::raw("INSERT INTO occupied_weeks_$jaar SELECT * FROM occupied_weeks GROUP BY ID"));
        
        DB::table("occupied_weeks_$jaar")->where('week', $onderhoudweek)->update(['bezet' => 1]);
        DB::table("occupied_weeks_$jaar")->where('week', $onderhoudweek)->update(['bezet' => 1]);

        if ($weeks_total == 52) {

            DB::table("occupied_weeks_$jaar")->where('week', 53)->update(['bezet' => 1]);

        }

        DB::table('options')->where('id', 1)->update(['value' => $jaar]);
        $request->session()->flash('message', 'Nieuw boekingsjaar aangemaakt.');

        return redirect('/admin/options');
    }

    public function userEncrypter(Request $request) {

        $users = User::get()->toArray();
        $number = 0;
        foreach ($users as $user) {
            $number ++;
            if ($number > 2) {
                User::where('id', $user['id'])->update([
                    'firstname' => Crypt::encrypt($user['firstname']),
                    'lastname' => Crypt::encrypt($user['lastname']),
                    'phone' => Crypt::encrypt($user['phone']),
                    'adress' => Crypt::encrypt($user['adress']),
                    'postcode' => Crypt::encrypt($user['postcode']),
                    'city' => Crypt::encrypt($user['city']),
                    'work_location' => Crypt::encrypt($user['work_location']),
                    'password' => bcrypt($user['password']),
                ]);
            }
        }

        $request->session()->flash('message', 'Encryptie successvol.');
        return redirect('/admin/options');
    }

}
