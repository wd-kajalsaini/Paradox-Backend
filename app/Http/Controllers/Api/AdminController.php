<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Managers;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
use App\Show;
use App\AppSection;
use App\ShowBanner;
use App\SectionShowLink;


class AdminController extends Controller {

    public function __construct() {

    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required'
        ]);
        $fields = array('email', 'password');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->wgetMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                    return response()->json(['status' => 0, 'message' => $error_message]);
                }
            }
        }
        $input = $request->all();
        $manager = Managers::where('email', $request->email)->first() ;
        if (!$manager) {
            return response()->json(['status' => 0, 'message' => "Email address not found."]);
        }


        if (!Hash::check($request->password, $manager->password)) {
            return response()->json(['status' => 0, 'message' => "Wrong password provided."]);
        }

        $managerDetail = Managers::select('id','first_name','last_name','email')->find($manager->id);
        $managerDetail->token = $managerDetail->get_api_validation_token($manager->id);
        return response()->json(['status' => 1, 'message' => 'Login successfully','data' => $managerDetail]);
    }

    public function sections() {
        $managerModel = new Managers;
        $id = $managerModel->validate_api_token();
        $sections = AppSection::with(['show_list' => function($query){
            $query->select('shows.id','title','banner','start_time','end_time','date','chat_room_id','live_at','stop_at');
        }])->orderBy('sort_order')->get()->each(function($query) {
            $query->limitRelationship('show_list', 5);
        });
        $home['sections'] = $sections;
        return response()->json(['status' => 1, 'data' => $home]);
    }

    public function banner(){
        $managerModel = new Managers;
        $id = $managerModel->validate_api_token();
        $shows = ShowBanner::with(['show' =>function($query){
            $query->select('id','title','banner','start_time','end_time','date','chat_room_id','live_at','stop_at');
        }])->orderBy('sort_order')->get();
        return response()->json(['status' => 1, 'data' => $shows]);
    }

    public function section_shows(Request $request){
        $managerModel = new Managers;
        $id = $managerModel->validate_api_token();
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

    public function show_detail(Request $request) {
        $managerModel = new Managers;
        $id = $managerModel->validate_api_token();
        $validator = Validator::make($request->all(), [
            'show_id' => 'required'
        ]);
        $fields = array('show_id');
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
        $show_detail = Show::with('show_questions')->find($input['show_id']);
        $decoded_team_1 = json_decode($show_detail->team_1_data);
        $decoded_team_2 = json_decode($show_detail->team_2_data);
        $show_detail->team_1_data = $decoded_team_1;
        $show_detail->team_2_data = $decoded_team_2;
        $teams = [$decoded_team_1,$decoded_team_2];
        $show_detail->teams = $teams;
        $show_detail->is_subscribed = 0;
        return response()->json(['status' => 1, 'data' => $show_detail]);
    }

}
