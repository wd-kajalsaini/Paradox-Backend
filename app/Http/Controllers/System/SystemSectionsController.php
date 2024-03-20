<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Managers;
use DB;
use App\Permissions;
use App\Sections;
use Route;
use App\ManagerTypes;
use Auth;
use Storage;
use Hash;
use File;

class SystemSectionsController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth');
    }

    // section listings
    public function sections() {
        $sections = Sections::where('parent_id', 'main')->orderBy('name', 'ASC')->with('subSections')->get()->toArray();
        $data['hSections'] = $sections;

        $data['page_title'] = 'system';
        $data['link'] = 'System_Sections';
        return view('system/systemSections', $data);
    }

    //add section
    public function addSection(Request $request) {
        if ($request->isMethod('post')) {

            $section = collect($request->all())->merge(['created_by' => Auth::user()->full_name, 'updated_by' => Auth::user()->full_name])->forget('_token')->toArray();
            DB::beginTransaction();
            try {
                $addSection = new Sections();
                $addSection->fill($section);
                $addSection->save();

                $managerTypes = ManagerTypes::where('name', '!=', 'Super Manager')->get();
                $permission = [];
                foreach ($managerTypes as $key => $managerType) {
                    $permission[$key]['manager_type_id'] = $managerType->id;
                    $permission[$key]['section_id'] = $addSection->id;
                    $permission[$key]['permission'] = 0;
                }
                $permission = Permissions::insert($permission);


                DB::commit();
                \Session::flash('message', 'Successfully Created Section');
                \Session::flash('class', 'success');
                return redirect()->route('sectionsListing');
            } catch (\Exception $e) {
                // something went wrong
                DB::rollback();
                \Session::flash('message', 'Unsuccessfully Created Section');
                \Session::flash('class', 'danger');
                return redirect()->route('sectionsListing');
            }
        } else {

            $routes = collect(Route::getRoutes())->map(function ($route) {
                return [
                    // 'host'   => $route->domain(),
                    // 'method' => implode('|', $route->methods()),
                    // 'uri'    => $route->uri(),
                    'name' => $route->getName(),
                        //'action' => $route->getActionName(),
                ];
            });

            $actions = [];
            foreach ($routes as $key => $routeName) {
                if ($routeName['name'] != "") {
                    if (strpos($routeName['name'], '.') == false) {

                        if ($routeName['name'] !== "login" && $routeName['name'] !== "logout" && $routeName['name'] !== "changePassword" && $routeName['name'] !== "unauthorized" && $routeName['name'] !== "comingSoon" && $routeName['name'] !== "setLocale" && (strpos($routeName['name'], 'Ajax') == false)) {
                            $actions[] = $routeName['name'];
                        }
                    }
                }
            }
            $YActions = [];
            $NActions = [];
            foreach ($actions as $action) {
                if (strpos($action, 'Listing') == true || strpos($action, 'Add') == true) {
                    $YActions[] = $action;
                } else {
                    $NActions[] = $action;
                }
            }


            $data['nActions'] = array_unique($NActions);
            $data['yActions'] = $YActions;
            $data['hSections'] = $this->tree();
            $data['page_title'] = 'system';
            $data['link'] = 'System_Sections';
            return view('system/addSection', $data);
        }
    }

    function tree($id = "main", $space = "", $arr = "", $count = 0) {
        global $conn;
        if (!is_array($arr))
            $arr = array();
        if ($count == 2) {
            return $arr;
        } else {
            $count = $count + 1;
        }
        $query = Sections::where('parent_id', $id)->get();

        if (count($query) > 0) {

            foreach ($query as $row) {
                $arr[] = array('id' => $row->id, 'name' => $space . $row->name);
                $arr = $this->tree($row->id, $space . '&mdash;', $arr, $count);
            }
        }
        return $arr;
    }

    public function editSection(Request $request, $id) {

        if ($request->isMethod('post')) {

            if (empty($request->route)) {

                $section = collect($request->all())->put('route', $request->hidden_route)->merge(['created_by' => Auth::user()->full_name, 'updated_by' => Auth::user()->full_name])->forget('_token')->forget('hidden_route')->toArray();
            } else {
                $section = collect($request->all())->merge(['created_by' => Auth::user()->full_name, 'updated_by' => Auth::user()->full_name])->forget('_token')->forget('hidden_route')->toArray();
            }
            DB::beginTransaction();
            try {
                $addSection = Sections::find($id);
                $addSection->fill($section);
                $addSection->update();
                DB::commit();
                \Session::flash('message', 'Successfully Updated Section');
                \Session::flash('class', 'success');
                return redirect()->route('sectionsListing');
            } catch (\Exception $e) {

                // something went wrong
                DB::rollback();
                \Session::flash('message', 'Unsuccessfully Updated Section');
                \Session::flash('class', 'danger');
                return redirect()->route('sectionsListing');
            }
        } else {
            $routes = collect(Route::getRoutes())->map(function ($route) {
                return [
                    // 'host'   => $route->domain(),
                    // 'method' => implode('|', $route->methods()),
                    // 'uri'    => $route->uri(),
                    'name' => $route->getName(),
                        //'action' => $route->getActionName(),
                ];
            });

            $actions = [];
            foreach ($routes as $key => $routeName) {
                if ($routeName['name'] != "") {
                    if (strpos($routeName['name'], '.') == false) {

                        if ($routeName['name'] !== "login" && $routeName['name'] !== "logout" && $routeName['name'] !== "changePassword" && $routeName['name'] !== "unauthorized" && $routeName['name'] !== "comingSoon" && $routeName['name'] !== "setLocale" && (strpos($routeName['name'], 'Ajax') == false)) {
                            $actions[] = $routeName['name'];
                        }
                    }
                }
            }
            $YActions = [];
            $NActions = [];
            foreach ($actions as $action) {
                if (strpos($action, 'Listing') == true || strpos($action, 'Add') == true) {
                    $YActions[] = $action;
                } else {
                    $NActions[] = $action;
                }
            }

            $data['selectSection'] = Sections::where('id', $id)->first();
            //print_r($data['selectSection']);die;
            $data['nActions'] = array_unique($NActions);
            $data['yActions'] = $YActions;
            $data['hSections'] = $this->tree();
            $data['page_title'] = 'system';
            $data['link'] = 'System_Sections';
            return view('system/editSection', $data);
        }
    }

    //re order sections
    public function reOrder(Request $request) {

        if ($request->isMethod('post')) {
            //print_r($request->all());

            $sections = $request->sections;
            $subSections = $request->subSections;
            DB::beginTransaction();
            try {
                foreach ($sections as $sort_order => $section_id) {
                    Sections::where('id', $section_id)->update(['sort_order' => $sort_order]);
                }

                foreach ($subSections as $subSec) {
                    foreach ($subSec as $sort_order => $section_id) {
                        Sections::where('id', $section_id)->update(['sort_order' => $sort_order]);
                    }
                }

                DB::commit();
                echo 1;
            } catch (\Exception $e) {

                DB::rollback();
                echo 0;
            }
        } else {
            $sections = Sections::where('parent_id', 'main')->with('subSections')->orderBy('sort_order', 'ASC')->get()->toArray();

            $data['sections'] = $sections;
            $data['page_title'] = 'system';
            $data['link'] = 'System_Sections';
            return view('system/order', $data);
        }
    }

}
