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
use App\WebsiteSetting;

class WebsiteSettingController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth');
    }

    /* Listing of push notifications by admin panel */

    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();

            $newData = WebsiteSetting::find(1);
//            echo "<pre>";
//            print_r($website_settings);
//            var_dump($website_settings);
//            die;
            if (!$newData) {
                $newData = new WebsiteSetting();
            }

            $newDataField = collect($input)->forget(['_token', '_method'])->toArray();
            $newData->fill($newDataField);
            if ($newData->save()) {
                \Session::flash('message', 'Settings updated successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('websiteSettingsAdd');
            }
        }
        $data['page_title'] = 'Website Settings';
        $data['link'] = 'Website_Settings';
        $data['website'] = WebsiteSetting::find(1);

        return view('website_setting.add', $data);
    }

}
