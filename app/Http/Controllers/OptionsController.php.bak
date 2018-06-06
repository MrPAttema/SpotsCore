<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use App\Options;
use DB;
use Session;
use Carbon\Carbon;

class OptionsController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth:admin');
  }

  public function index()
  {
      $boekingsjaar = DB::table('options')->where('id', 1)->value('value');
      $autotoewijzen = DB::table('options')->where('id', 2)->value('value');
      $ronde1 = DB::table('options')->where('id', 3)->value('value');
      $ronde2 = DB::table('options')->where('id', 4)->value('value');   
      $dubbeleboekingen = DB::table('options')->where('id', 5)->value('value');
      $reservations = DB::table('reservations')->orderBy('created_at', 'desc')->first();
      $occupied_weeks = DB::table("occupied_weeks")->get();
      return view('admin.options', compact('reservations', 'options', 'boekingsjaar', 'ronde1', 'ronde2', 'autotoewijzen', 'dubbeleboekingen', 'occupied_weeks'));
  }

  public function update(Request $request)
  {
      $ronde1 = $request->ronde1;
      $ronde2 = $request->ronde2;
      $autotoewijzen = $request->autotoewijzen;
      $dubbeleboekingen = $request->dubbeleboekingen;

      DB::table('options')->where('id', 2)->update(['value' => $autotoewijzen]);
      DB::table('options')->where('id', 3)->update(['value' => $ronde1]);
      DB::table('options')->where('id', 4)->update(['value' => $ronde2]);
      DB::table('options')->where('id', 5)->update(['value' => $dubbeleboekingen]);

      $request->session()->flash('message', 'Instellingen zijn opgeslagen.');
      return redirect('/admin/options');
  }

    public function newyear(Request $request)
    {
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

        if ($weeks_total == 52){

            DB::table("occupied_weeks_$jaar")->where('week', 53)->update(['bezet' => 1]);

        }

        DB::table('options')->where('id', 1)->update(['value' => $jaar]);
        $request->session()->flash('message', 'Nieuw boekingsjaar aangemaakt.');

        return redirect('/admin/options');
    }
}
