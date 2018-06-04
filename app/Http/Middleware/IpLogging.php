<?php

namespace App\Http\Middleware;

use DB;
use Closure;
use carbon\Carbon;
use App\Loggings;
use Illuminate\Support\Facades\Auth;

class IpLogging
{
    /**
     * The trusted proxies for this application.
     *
     * @var array
     */
    protected $userAgent;


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ipAddress = '';

        // Check for X-Forwarded-For headers and use those if found
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ('' !== trim($_SERVER['HTTP_X_FORWARDED_FOR']))) {
            $ipAddress = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            if (isset($_SERVER['REMOTE_ADDR']) && ('' !== trim($_SERVER['REMOTE_ADDR']))) {
                $ipAddress = trim($_SERVER['REMOTE_ADDR']);
            }
        }

        if (isset($_SERVER['HTTP_USER_AGENT']) && ('' !== trim($_SERVER['HTTP_USER_AGENT']))) {
            $userAgent = trim($_SERVER['HTTP_USER_AGENT']);
        } 

        $os_platform = "Onbekende OS";

        $os_array = array(
            '/windows nt 10/i'     =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobiel'
        );

        foreach ($os_array as $regex => $value) { 

            if (preg_match($regex, $userAgent)) {
                $os_platform    =   $value;
            }

        }  

        $browser = "Onbekende browser";

        $browser_array = array(
            '/msie/i'       =>  'Internet Explorer',
            '/firefox/i'    =>  'Firefox',
            '/safari/i'     =>  'Safari',
            '/chrome/i'     =>  'Chrome',
            '/edge/i'       =>  'Edge',
            '/opera/i'      =>  'Opera',
            '/netscape/i'   =>  'Netscape',
            '/maxthon/i'    =>  'Maxthon',
            '/konqueror/i'  =>  'Konqueror',
            '/mobile/i'     =>  'Mobiele Browser'
        );

        foreach ($browser_array as $regex => $value) { 

            if (preg_match($regex, $userAgent)) {
                $browser    =   $value;
            }

        }

        $userOS = $os_platform;
        $userBrowser = $browser;
        $currentUserID = Auth::id();
        $currentTime = Carbon::now();

        DB::table('logging')->insert([
            'user_id' => $currentUserID,
            'ip_adress' => encrypt($ipAddress),
            'location' => 0,
            'platform' => $userOS,
            'browser' => $userBrowser,
            'created_at' => $currentTime,
        ]);
       
        return $next($request);
    }
}
