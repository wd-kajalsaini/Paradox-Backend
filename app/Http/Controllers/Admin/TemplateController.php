<?php

namespace App\Http\Controllers\Admin;

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
use App\Dictionary;
use App;
use Cookie;
use App\User;
use View;
use App\AppSettingTemplate;

class TemplateController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth');
    }

    public function index(Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            // echo "<pre>";
            // print_r($input);die;
            $newData = AppSettingTemplate::first();
            $newDataField = collect($input)->forget(['_token', '_method'])->toArray();
            $newData->fill($newDataField);
            if ($newData->save()) {
                \Session::flash('message', 'Template updated successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('templateManagementListing');
            }
        }
        $data['page_title'] = 'Template Management';
        $data['link'] = 'Template_Management';
        $data['templates'] = AppSettingTemplate::first();
        return view('template_management.index', $data);
    }

}
