<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\AppContent;
use App\AppContentField;
use App\MaxLimit;
use App\UserPrefix;

class HomeController extends Controller {

    public function __construct() {

    }

    /* App Content Data with limitations */

    public function index() {
        $app_contents = AppContent::get();
        foreach ($app_contents as $app_content_key => $app_content) {
            $english_fields = [];
            $hebrew_fields = [];
            foreach (explode(',', $app_content->fields) as $field) {
                if (strpos($field, '_english') !== false) {
                    $english_fields[] = $field . ' as ' . str_replace("_english", "", $field);
                } elseif (strpos($field, '_hebrew') !== false) {
                    $hebrew_fields[] = $field . ' as ' . str_replace("_hebrew", "", $field);
                }
            }
            $app_contents[$app_content_key]->english = AppContentField::select(DB::raw(implode(',', $english_fields)))->where(['app_content_id' => $app_content->id])->first();
            // $app_contents[$app_content_key]->hebrew = AppContentField::select(DB::raw(implode(',', $hebrew_fields)))->where(['app_content_id' => $app_content->id])->first();
        }
        return response()->json(['status' => 1, 'data' => $app_contents]);
    }

}
