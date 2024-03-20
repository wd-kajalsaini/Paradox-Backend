<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\AppSection;
use App\Show;
use App\SubscribedShow;

class ShowController extends Controller {

    public function __construct() {

    }

    /* Show Detail */

    public function detail(Request $request) {
        $user = Auth::user();
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
        $is_subscribed = SubscribedShow::where(['show_id' => $show_detail->id,'user_id' => $user->id])->first();
        if($is_subscribed){
            $show_detail->is_subscribed = 1;
        } else {
            $show_detail->is_subscribed = 0;
        }
        return response()->json(['status' => 1, 'data' => $show_detail]);
    }

    public function update_room(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'show_id' => 'required',
            'chat_room_id' => 'required'
        ]);
        $fields = array('show_id','chat_room_id');
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
        $show_detail = Show::find($input['show_id']);
        if(empty($show_detail->chat_room_id)){
            $show_detail->fill(['chat_room_id' => (!empty($input['chat_room_id']))?$input['chat_room_id']:""]);
            $show_detail->save();
            return response()->json(['status' => 1, 'message' => "Show updated successfully"]);
        } else {
            return response()->json(['status' => 0, 'message' => $show_detail->chat_room_id]);
        }
    }

}
