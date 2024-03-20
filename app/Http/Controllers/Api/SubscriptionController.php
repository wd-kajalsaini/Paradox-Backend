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

class SubscriptionController extends Controller {

    public function __construct() {

    }

    /* Show Detail */

    public function mark_unmark(Request $request) {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'show_id' => 'required',
            'is_subscription' => 'required'
        ]);
        $fields = array('show_id','is_subscription');
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
        $is_subscribed = SubscribedShow::where(['show_id' => $input['show_id'],'user_id' => $user->id])->first();
        if($input['is_subscription'] == 1){
            if(!$is_subscribed){
                $subscribe = new SubscribedShow();
                $subscribe->fill(['show_id' => $input['show_id'], 'user_id' => $user->id]);
                $subscribe->save();
            }
            return response()->json(['status' => 1, 'message' => "Subscribed Successfully"]);
        }
        if($input['is_subscription'] == 0){
            if($is_subscribed){
                $is_subscribed->delete();
            }
            return response()->json(['status' => 1, 'message' => "Unsubscribed Successfully"]);
        }

    }



}
