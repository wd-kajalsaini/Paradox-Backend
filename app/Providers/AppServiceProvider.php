<?php

namespace App\Providers;
use App\Sections;
use Illuminate\Support\ServiceProvider;
//use Illuminate\Contracts\View\View;
use View;
use Cookie;
use Crypt;
use Hash;
use Auth;
use DB;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('layouts/header', function ($view)
        {
            $manager = Auth::user();
            $sections = Sections::where(['show_on_sidebar'=>'yes','parent_id'=>'main'])->with(['permission'=>function($query)use($manager){
                                            $query->where('manager_type_id',$manager->type_id);
                                            }])->orderBy('sort_order', 'ASC')->get()->toArray();
            foreach ($sections as $key => $section)
            {

                $sections[$key]['subSections'] = Sections::where(['show_on_sidebar'=>'yes','parent_id'=>$section['id']])->with(['permission'=>function($query)use($manager){
                                                        $query->where('manager_type_id',$manager->type_id);
                                                        }])->orderBy('sort_order', 'ASC')->get()->toArray();
            }
            // echo "<pre>";
            // print_r($sections);die;

            $view->with('sections', $sections );
        });

    }

}
