<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;

class PhoneVerificationController extends Controller {

    public function __construct() {

    }

    /* Send code via phone number */

    public function sendCode(Request $request) {
        $validator = Validator::make($request->all(), [
                    'country_code' => 'required',
                    'phone_no' => 'required',
                    'screen_type' => 'required',
                    'country_code_two_digit' => 'required'
        ]);
        $fields = array('country_code', 'phone_no', 'screen_type', 'country_code_two_digit');
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
        $encrypted_code = '';
        if(!empty($input['encrypted_code'])){
            $encrypted_code = ". Message Id: ".$input['encrypted_code'];
        }
        $input['phone_no'] = ltrim($input['phone_no'], "0");
        $userDetail = User::where(['country_code' => $input['country_code'], 'phone_no' => $input['phone_no']])->first();
        if (!empty($userDetail) && $input['screen_type'] == 'register' && $userDetail->is_register == 1) {
            return response()->json(['status' => 0, 'message' => "This phone exists in the system please try again or try to login with it."]);
        }
        if ($input['screen_type'] == 'login' && (empty($userDetail) || empty($userDetail->is_register))) {
            return response()->json(['status' => 0, 'message' => "This phone doesn't exists in the system. Please register with it."]);
        }

        if ($input['screen_type'] == 'register') {
            $random_no = rand(10000, 99999);
            if (empty($userDetail)) {
                $register = new User();
            } else {
                $register = User::find($userDetail->id);
            }
            $register->fill(['country_code' => $input['country_code'], 'phone_no' => $input['phone_no'], 'phone_verification_code' => $random_no]);
            $send = $this->SendSMS('<#> Your OTP for Kvitel is: ' . $random_no.$encrypted_code, $input['country_code'] . $input['phone_no'], $input['country_code_two_digit']);
            $xml = simplexml_load_string($send) or die("Error: Cannot create object");
            if ($xml->Status == 1) {
                $register->save();
                return response()->json(['status' => 1, 'message' => "OTP send successfully"]);
            } else {
                return response()->json(['status' => 0, 'message' => $xml->Description->__toString(), "error_code" => $xml->Status->__toString()]);
            }
        }
        if ($input['screen_type'] == 'login') {
            $random_no = rand(10000, 99999);
            $login = User::find($userDetail->id);
            $login->fill(['phone_verification_code' => $random_no]);
            $send = $this->SendSMS('<#> Your OTP for Kvitel is: ' . $random_no.$encrypted_code, $input['country_code'] . $input['phone_no'], $input['country_code_two_digit']);
            $xml = simplexml_load_string($send) or die("Error: Cannot create object");
            if ($xml->Status == 1) {
                $login->save();
                return response()->json(['status' => 1, 'message' => "OTP send successfully"]);
            } else {
                return response()->json(['status' => 0, 'message' => $xml->Description->__toString(), "error_code" => $xml->Status->__toString()]);
            }
        }
    }

    /* Common function to send sms */

    function SendSMS($message_text, $recepients, $country_code_two_digit) {
        if ($country_code_two_digit == 'IL') {
            $sms_user = SMS_ISRAEL_USER; // User Name (Provided by Inforu)
            $sms_apitoken = SMS_ISRAEL_TOKEN;
        } else {
            $sms_user = SMS_WORLD_USER; // User Name (Provided by Inforu)
            $sms_apitoken = SMS_WORLD_TOKEN; // Password (Provided by Inforu)
        }
        $sms_sender = SMS_SENDER; //
        $message_text = preg_replace("/\r|\n/", "", $message_text); // remove line breaks
        $xml = '';
        $xml .= '<Inforu>' . PHP_EOL;
        $xml .= ' <User>' . PHP_EOL;
        $xml .= ' <Username>' . htmlspecialchars($sms_user) . '</Username>' . PHP_EOL;
        $xml .= ' <ApiToken>' . htmlspecialchars($sms_apitoken) . '</ApiToken>' . PHP_EOL;
        $xml .= ' </User>' . PHP_EOL;
        $xml .= ' <Content Type="sms">' . PHP_EOL;
        $xml .= ' <Message>' . htmlspecialchars($message_text) . '</Message>' . PHP_EOL;
        $xml .= ' </Content>' . PHP_EOL;
        $xml .= ' <Recipients>' . PHP_EOL;
        $xml .= ' <PhoneNumber>' . htmlspecialchars($recepients) . '</PhoneNumber>' . PHP_EOL;
        $xml .= ' </Recipients>' . PHP_EOL;
        $xml .= ' <Settings>' . PHP_EOL;
        $xml .= ' <Sender>' . htmlspecialchars($sms_sender) . '</Sender>' . PHP_EOL;
        $xml .= ' </Settings>' . PHP_EOL;
        $xml .= '</Inforu>';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://uapi.inforu.co.il/SendMessageXml.ashx');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'InforuXML=' . urlencode($xml));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /* Resend Code */

    function resendCode(Request $request) {
        $validator = Validator::make($request->all(), [
                    'country_code' => 'required',
                    'phone_no' => 'required',
                    'country_code_two_digit' => 'required'
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
        $encrypted_code = '';
        if(!empty($input['encrypted_code'])){
            $encrypted_code = ". Message Id: ".$input['encrypted_code'];
        }
        $input['phone_no'] = ltrim($input['phone_no'], "0");
        $userDetail = User::where(['country_code' => $input['country_code'], 'phone_no' => $input['phone_no']])->first();
        if (empty($userDetail)) {
            return response()->json(['status' => 0, 'message' => "This phone doesn't exists in the system."]);
        }
        $random_no = rand(10000, 99999);
        $userDetail->fill(['phone_verification_code' => $random_no]);
        $send = $this->SendSMS('<#> Your OTP for Kvitel is: ' . $random_no.$encrypted_code, $input['country_code'] . $input['phone_no'], $input['country_code_two_digit']);
        $xml = simplexml_load_string($send) or die("Error: Cannot create object");
        if ($xml->Status == 1) {
            $userDetail->save();
            return response()->json(['status' => 1, 'message' => "OTP send successfully"]);
        } else {
            return response()->json(['status' => 0, 'message' => $xml->Description->__toString(), "error_code" => $xml->Status->__toString()]);
        }
    }

    /* Match code */

    public function verify_code(Request $request) {
        $validator = Validator::make($request->all(), [
                    'country_code' => 'required',
                    'phone_no' => 'required',
                    'otp' => 'required'
        ]);
        $fields = array('country_code', 'phone_no', 'otp');
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
        if (empty($userDetail)) {
            return response()->json(['status' => 0, 'message' => "This phone doesn't exists in the system."]);
        } else {
            if ($userDetail->phone_verification_code == $input['otp']) {
                $userDetail->fill(['phone_verification_code' => '']);
                $userDetail->save();
                return response()->json(['status' => 1, 'message' => "Verification Done Successfully"]);
            } else {
                return response()->json(['status' => 0, 'message' => "Please enter correct OTP"]);
            }
        }
    }

}
