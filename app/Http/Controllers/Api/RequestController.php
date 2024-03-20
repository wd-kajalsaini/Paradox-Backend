<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\InfoRequest;

class RequestController extends Controller {

    public function __construct() {

    }

    public function apply_request(Request $request){
        $input = $request->all();
        $validator = Validator::make($request->all(), [
                    'request_to' => 'required',
                    'request_table' => 'required',
                    'table_id' => 'required',
                    'request_regarding' => 'required'
        ]);
        $fields = array('request_to','request_table','table_id','request_regarding');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                    return response()->json(['status' => 0, 'message' => $error_message]);
                }
            }
        }
        $user = Auth::user();
        $checkRecord = InfoRequest::where(['request_from' => $user->id,'request_to' => $input['request_to'],'request_table' => $input['request_table'], 'table_id' => $input['table_id'], 'request_regarding' => $input['request_regarding']])->first();
        if($checkRecord){
            return response()->json(['status' => 0, 'message' => "You already applied a request for the same."]);
        }
        $newRequest = new InfoRequest;
        $requestData = ['request_from' => $user->id,'request_to' => $input['request_to'],'requester_name' => $user->first_name." ".$user->last_name, 'requester_image' => $user->avatar,'request_table' => $input['request_table'], 'table_id' => $input['table_id'], 'request_regarding' => $input['request_regarding']];
        $newRequest->fill($requestData);
        $newRequest->save();
        return response()->json(['status' => 1, 'message' => "Request send successfully"]);
    }

    public function my_requests(){
        $user = Auth::user();
        $myRequests = InfoRequest::where(['request_to' => $user->id])->orderBy('status','desc')->get();
        return response()->json(['status' => 1, 'data' => $myRequests]);
    }


}
