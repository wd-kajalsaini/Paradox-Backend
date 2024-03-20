<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\CountryExtension;
use App\KvitelProduct;

class KvitelIdController extends Controller {

    public function __construct() {
        
    }

    public function generateKvitelId(Request $request) {
        $validator = Validator::make($request->all(), [
                    'country_code' => 'required',
                    'phone_no' => 'required',
                    'country_code_two_digit' => 'required',
        ]);
        $fields = array('country_code', 'phone_no', 'country_code_two_digit');
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
        $input['phone_no'] = ltrim($input['phone_no'], "0");
        $userDetail = User::where(['country_code' => $input['country_code'], 'phone_no' => $input['phone_no']])->first();
        $extensionDetail = CountryExtension::where(['country_code' => $input['country_code_two_digit']])->first();
        if (empty($userDetail)) {
            return response()->json(['status' => 0, 'message' => "This phone doesn't exists in the system. Please register with it."]);
        } else {
            if (!empty($extensionDetail)) {
                if (empty($userDetail->kvitel_id)) {
                    $userModel = new User();
                    $kvitel_id = $userModel->generate_kvitel($extensionDetail->extension);
                    User::where(['id' => $userDetail->id])->update(['kvitel_extension' => $extensionDetail->extension, 'kvitel_id' => $kvitel_id]);
                }
                $returnData = User::select('kvitel_extension', 'kvitel_id')->where(['country_code' => $input['country_code'], 'phone_no' => $input['phone_no']])->first();
                return response()->json(['status' => 1, 'message' => "Kvitel Data", "data" => $returnData]);
            } else {
                return response()->json(['status' => 0, 'message' => "This phone doesn't lauch for your country. Please wait for few days"]);
            }
        }
    }

    /* List of Kvitel Id Products */

    public function list_of_products() {
        $products = KvitelProduct::get();
        return response()->json(['status' => 1, 'data' => $products]);
    }

    /* validate Kvitel Id */

    public function validate_id(Request $request) {
        $validator = Validator::make($request->all(), [
                    'extension' => 'required',
                    'kvitel_id' => 'required'
        ]);
        $fields = array('extension', 'kvitel_id');
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
        $userModel = new User();
        $kvitel_id = $userModel->validate_kvitel($input['extension'], $input['kvitel_id']);
        print_r($kvitel_id->content());
    }

    /* Update Kvitel ID */

    public function updateKvitelId(Request $request) {
        $validator = Validator::make($request->all(), [
                    'country_code' => 'required',
                    'phone_no' => 'required',
                    'kvitel_id' => 'required'
        ]);
        $fields = array('country_code', 'phone_no', 'kvitel_id');
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
        $input['phone_no'] = ltrim($input['phone_no'], "0");
        $userDetail = User::where(['country_code' => $input['country_code'], 'phone_no' => $input['phone_no']])->first();
        $updateData['kvitel_id'] = $input['kvitel_id'];
        if (!empty($input['product'])) {
            $updateData['product'] = $input['product'];
        }
        if (!empty($input['sum_paid'])) {
            $updateData['sum_paid'] = $input['sum_paid'] + $userDetail->sum_paid;
        }
        User::where(['country_code' => $input['country_code'], 'phone_no' => $input['phone_no']])->update($updateData);
        return response()->json(['status' => 1, 'message' => "Congratulations, you have personalized the KVITEL ID !"]);
    }

}
