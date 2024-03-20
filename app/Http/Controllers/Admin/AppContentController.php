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
use App\AppContent;
use App\AppContentField;
use App\MaxLimit;

class AppContentController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth', ['except' => ['app_content_field_ajax']]);
    }

    /* Retrieve all the application users */

    public function index(Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $fieldData = AppContentField::where(['app_content_id' => $input['app_content_id']])->first();
            if (!empty($fieldData)) {
                $newData = AppContentField::find($fieldData->id);
            } else {
                $newData = new AppContentField();
            }
            $newDataField = collect($input)->forget(['_token', '_method'])->toArray();
            $tableField = ['title_english','title_hebrew','description_english','description_hebrew','error_english','error_hebrew','alert_english','alert_hebrew','explantion_popup1_title_english','explantion_popup1_title_hebrew','explantion_popup1_description_english','explantion_popup1_description_hebrew','explantion_popup2_title_english','explantion_popup2_title_hebrew','explantion_popup2_description_english','explantion_popup2_description_hebrew','camera_english','camera_hebrew','gallery_english','gallery_hebrew','app_content_id'];

            foreach ($tableField as $tableFieldValue) {
                $newDataField[$tableFieldValue] = (isset($newDataField[$tableFieldValue]) && !empty($newDataField[$tableFieldValue])) ? $newDataField[$tableFieldValue] : "";
            }
            $newData->fill($newDataField);
            if ($newData->save()) {
                \Session::flash('message', 'Data updated successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('contentManagementListing');
            }
        }
        $data['page_title'] = 'App Content Management';
        $data['link'] = 'App_Settings';
        $data['app_contents'] = AppContent::get();
        $data['limits'] = MaxLimit::find(1);
        return view('app_content.index', $data);
    }

    /* get data regarding app screen using ajax */

    public function app_content_field_ajax(Request $request) {
        $input = $request->all();
        $content = AppContent::with('fieldData')->where(['id' => $input['app_content_id']])->first()->toArray();
        return view('app_content.app_content_field_ajax', ['content' => $content]);
    }

}
