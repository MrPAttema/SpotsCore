<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UpdateController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function getVersionInfo() {

        $softwareKey = DB::table('options')->where('id', 7)->value('value');
        $currentSoftwareVersion = DB::table('options')->where('id', 8)->value('value');
        $currentAPIVersion = DB::table('options')->where('id', 9)->value('value');
        $currentSoftwareID = DB::table('options')->where('id', 10)->value('value');   
        $currentSoftwareStatus = DB::table('options')->where('id', 11)->value('value');

        $versionPacket = array(
            "softwareVersion" => $currentSoftwareVersion,
            "apiVersion" => $currentAPIVersion,
            "softwareID" => $currentSoftwareID,
            "softwareStatus" => $currentSoftwareStatus,
        );

        return $versionPacket;
    }
    
    public function postVersionInfo(Request $request) {

        $versionPacket = json_decode($request);

        DB::table('options')->where('id', 8)->update(['value' => $request->softwareVersion]);
        DB::table('options')->where('id', 9)->update(['value' => $request->apiVersion]);
        DB::table('options')->where('id', 10)->update(['value' => $request->softwareID]);
        DB::table('options')->where('id', 11)->update(['value' => $request->softwareStatus]);


    }

    public function checkRequest() {
        
        $curl = curl_init();

        $versionPacket = array(
            'currentSoftwareVersion' => $currentSoftwareVersion, 
            'currentAPIVersion' => $currentAPIVersion,
            'currentSoftwareID' => $currentSoftwareID,
            'softwareKey' => $softwareKey,
            'status' => $currentSoftwareStatus,
            'activationDate' => '2017-05-19'
        );

        $versionPacket = json_encode($versionPacket);

        $url = 'http://spotscore.test/api/update/getversion/';

        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_USERAGENT      => "test", // name of client
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $versionPacket,
            CURLOPT_HTTPHEADER, array(                                                                          
                'Content-Type: application/json'
            )                                                                     
        );
            
        $curl = curl_init($url);
        curl_setopt_array($curl, $options);

        $result = curl_exec($curl);

        var_dump($result);

        curl_close($curl);
    }
    
}
