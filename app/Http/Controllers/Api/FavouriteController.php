<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\UserFavourite;
use App\KvitelContact;
use App\WorkingHoursUser;

class FavouriteController extends Controller {

    public function __construct() {

    }

    public function index(Request $request) {
        $user = Auth::user();
        $input = $request->all();
        $contacts = User::where(['id' => $user->id])->first()->favourites()->select("users.id", "users.kvitel_extension", "kvitel_id", "user_type" ,"first_name", "last_name", "avatar", "country_code", "phone_no")->get();
        if($contacts){
            if(!empty($input['current_time'])){
                $current_time = $input['current_time'];
            } else {
                $current_time = date("H:i");
            }

            if(!empty($input['current_day'])){
                $current_day = $input['current_day'];
            } else {
                $current_day = date('l');
            }
            foreach ($contacts as $contact_key => $contact_value) {
                $contacts[$contact_key]->is_favourite = 1;
                $alreadyContact = KvitelContact::where(['user_id' => $user->id, 'contact_id' => $contact_value->id])->first();
                if ($alreadyContact) {
                    $contacts[$contact_key]->is_friend = 1;
                } else {
                    $contacts[$contact_key]->is_friend = 0;
                }

                $workingHours = WorkingHoursUser::where(['day' => $current_day,'user_id' => $user->id])
                ->whereRaw("from_time <= '" . $current_time . "' && until_time >= '" . $current_time . "'")->first();
                if($workingHours){
                    $contacts[$contact_key]->opening_status = "Open";
                } else {
                    $contacts[$contact_key]->opening_status = "Closed";
                }
            }
        }
        return response()->json(['status' => 1, 'data' => $contacts]);
    }

    public function mark_unmark(Request $request) {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
                    'favourite_id' => 'required',
                    'is_favourite' => 'required'
        ]);
        $fields = array('favourite_id', 'is_favourite');
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
        $alreadyFavourite = UserFavourite::where(['user_id' => $user->id, 'favourite_id' => $input['favourite_id']])->first();
        if ($input['is_favourite'] == 1) {
            if (!$alreadyFavourite) {
                UserFavourite::insert(['user_id' => $user->id, 'favourite_id' => $input['favourite_id'], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            }
            return response()->json(['status' => 1, 'message' => "Mark Favourite successfully"]);
        }
        if ($input['is_favourite'] == 0) {
            if ($alreadyFavourite) {
                $alreadyFavourite->delete();
            }
            return response()->json(['status' => 1, 'message' => "Mark to unfavourite successfully"]);
        }
    }

}
