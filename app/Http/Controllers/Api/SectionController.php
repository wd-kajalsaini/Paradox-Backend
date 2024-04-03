<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\AppSection;
use App\ShowBanner;
use App\SectionShowLink;

class SectionController extends Controller {

    public function __construct() {

    }

    /* Sections */

    public function index() {
        $sections = AppSection::with(['show_list' => function($query){
            $query->select('shows.id','title','banner','start_time','end_time','date','chat_room_id','live_at','stop_at');
        }])->orderBy('sort_order')->get()->each(function($query) {
            $query->limitRelationship('show_list', 5);
        });
        $home['sections'] = $sections;
        return response()->json(['status' => 1, 'data' => $home]);
    }


    public function banner(){
        $shows = ShowBanner::with(['show' =>function($query){
            $query->select('id','title','banner','start_time','end_time','date','chat_room_id','live_at','stop_at');
        }])->orderBy('sort_order')->get();
        return response()->json(['status' => 1, 'data' => $shows]);
    }

    public function section_shows(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'section_id' => 'required'
        ]);
        $fields = array('section_id');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                    return response()->json(['status' => 0, 'message' => $error_message]);
                }
            }
        }
        $input = $request->all();
        $shows_list = SectionShowLink::select('shows.id','shows.title','shows.banner')->join('shows','section_show_links.show_id' ,'=','shows.id')
        ->where(['section_show_links.section_id' => $input['section_id']])->get();
        return response()->json(['status' => 1, 'data' => $shows_list]);
    }

}
