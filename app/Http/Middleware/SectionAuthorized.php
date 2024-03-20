<?php

namespace App\Http\Middleware;
use App\Sections;
use App\ManagerTypes;
use Closure;
use App\Permissions;
use DB;
class SectionAuthorized
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

        $manager = auth()->user();
        if($manager->role!="Admin")
        {

            $action = \Request::route()->getName();
            if($action!="setLocale")
            {


                $checkAuthorized = DB::table('sections')
                                    ->join('permissions', function ($join) use ($manager,$action) {
                                        $join->on('sections.id', '=', 'permissions.section_id')->where('permissions.permission','!=','0')->where('permissions.manager_type_id', '=', $manager->type_id)->where('sections.route',$action);
                                    })->first();
                // echo "<pre>";
                // print_r($checkAuthorized);die;
                if(!$checkAuthorized)
                {
                    return redirect()->route('unauthorized');
                }

                if($request->_token)
                {
                    if($checkAuthorized->permission!==2)
                    {
                        // echo "<pre>";
                        // print_r($checkAuthorized);die;
                        return redirect()->route('unauthorized');
                    }
                }
                if($checkAuthorized->permission==0)
                {
                    return redirect()->route('unauthorized');
                }
            }
        }


        return $next($request);
    }
}
