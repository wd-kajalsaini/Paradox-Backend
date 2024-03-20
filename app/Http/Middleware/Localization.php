<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use App;
use Auth;
class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        $cookie="en";
        if(Cookie::get('locale'.Auth::user()->id))
        {
            if(Cookie::get('locale'.Auth::user()->id)=="english")
            {
                $cookie="en";
            }
            if(Cookie::get('locale'.Auth::user()->id)=="russian")
            {
                $cookie="ru";
            }
            if(Cookie::get('locale'.Auth::user()->id)=="arabic")
            {
                $cookie="ar";
            }
            if(Cookie::get('locale'.Auth::user()->id)=="hebrew")
            {
                $cookie="hb";
            }


        }

        // echo $cookie;die;
        App::setLocale($cookie);
        // echo $cookie;
        // echo App::getLocale();die;
        //echo $cookie;die;
        return $next($request);
    }
}
