<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\Forgot;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Mail;
use Validator;

class UserController extends Controller
{

    public function __construct()
    {

    }

    /* User registration via email */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'email',
                Rule::unique('users')->where(function ($query) {
                    $query->where(['is_verified' => 1]);
                }),
            ],
            'password' => 'required',
            'phone_number' => ['required',
                Rule::unique('users')->where(function ($query) {
                    $query->where(['is_verified' => 1]);
                }),
            ],
            'gender' => 'required',
        ]);
        $fields = array('name', 'email', 'password', 'phone_number', 'gender');
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
        $userData = User::where('email', '=', $input['email'])->first();
        if (!empty($userData) && $userData->is_verified == 1) {
            return response()->json(['status' => 0, 'message' => "Email exists please change it"]);
        }
        try {
            $fillableData = ['name' => $input['name'], 'gender' => $input['gender'], 'email' => $input['email'], 'password' => Hash::make($input['password']), 'is_verified' => 0, 'install_date' => Date('Y-m-d'), 'phone_number' => $input['phone_number']];
            if (!empty($input['device_type'])) {
                $fillableData['device_type'] = $input['device_type'];
            } else {
                $fillableData['device_type'] = "";
            }
            if (!empty($input['app_version'])) {
                $fillableData['app_version'] = $input['app_version'];
            } else {
                $fillableData['app_version'] = "";
            }
            if (!empty($input['notification_token'])) {
                $fillableData['notification_token'] = $input['notification_token'];
            } else {
                $fillableData['notification_token'] = "";
            }
            if (!$userData) {
                $userData = new User();
            }
            $userData->fill($fillableData);
            $userData->save();
            $fourdigitrandom = rand(1000, 9999);
            $userData->fill(['email_verification_code' => $fourdigitrandom]);
            $userData->save();
            $mailResp = Mail::to([$input['email']])->send(new Forgot(['email_verification_code' => $fourdigitrandom, 'userName' => $input['name']], ['subject' => 'Email Verification Code', 'view' => 'email_template/email_verification']));

            return response()->json(['status' => 1, 'message' => 'Registration successful. Verify your Email.']);
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Something went wrong']);
        }
    }

    /* Verify email with the code send on email */

    public function verify_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required',
        ]);
        $fields = array('email', 'code');
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
        $userData = User::where('email', '=', $input['email'])->first();
        if (empty($userData)) {
            return response()->json(['status' => 0, 'message' => "Email doesn't exist in our system"]);
        }
        if ($userData->is_verified == 1) {
            return response()->json(['status' => 0, 'message' => "Email already verified"]);
        }
        if ($userData->email_verification_code == $input['code']) {
            $fillableData = ['is_verified' => 1, 'email_verification_code' => ""];
            if (!empty($input['device_type'])) {
                $fillableData['device_type'] = $input['device_type'];
            }
            if (!empty($input['app_version'])) {
                $fillableData['app_version'] = $input['app_version'];
            }
            if (!empty($input['notification_token'])) {
                $fillableData['notification_token'] = $input['notification_token'];
            }
            $userData->fill($fillableData);
            $userData->save();
            $userData->token = $userData->createToken('paradoxa')->accessToken;
            return response()->json(['status' => 1, 'message' => 'Email verified successfully.', 'data' => $userData]);
        } else {
            return response()->json(['status' => 0, 'message' => "Wrong code provided."]);
        }

    }

    /* User login via email */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $fields = array('email', 'password');
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
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 0, 'message' => 'Email address not found.']);
        }
        if ($user->status == 'Block') {
            return response()->json(['status' => 0, 'message' => 'Your account is blocked at this moment']);
        }

        if ($user->is_verified == 0) {
            $fourdigitrandom = rand(1000, 9999);
            $user->fill(['email_verification_code' => $fourdigitrandom]);
            $user->save();
            $mailResp = Mail::to([$input['email']])->send(new Forgot(['email_verification_code' => $fourdigitrandom, 'userName' => $user->name], ['subject' => 'Email Verification Code', 'view' => 'email_template/email_verification']));
            return response()->json(['status' => 1, 'data' => ['is_verified' => 0], 'message' => 'Email address not verified yet.']);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 0, 'message' => 'Wrong password provided.']);
        }
        $userdetail = User::find($user->id);

        $fillableData = [];
        if (!empty($input['device_type'])) {
            $fillableData['device_type'] = $input['device_type'];
        }
        if (!empty($input['app_version'])) {
            $fillableData['app_version'] = $input['app_version'];
        }
        if (!empty($input['notification_token'])) {
            $fillableData['notification_token'] = $input['notification_token'];
        }
        $userdetail->fill($fillableData);
        $userdetail->save();

        $userdetail = User::find($user->id);

        $userdetail->token = $userdetail->createToken('paradoxa')->accessToken;
        // dd($userdetail);

        return response()->json(['status' => 1, 'message' => 'Login successful', 'data' => $userdetail]);
    }

    /* View Profile */

    public function view()
    {
        $user = Auth::user();
        if ($user) {
            return response()->json(['status' => 1, 'data' => $user]);
        } else {
            return response()->json(['status' => 0, 'message' => "User Doesn't exist"]);
        }
    }

    public function social_login(Request $request)
    {
        $input = $request->all();
        if (empty($input['google_token']) && empty($input['facebook_token']) && empty($input['apple_token'])) {
            return response()->json(['status' => 0, 'message' => "Must send social token"]);
        }

        if (isset($input['email']) && !empty($input['email'])) {
            $user_check = User::where('email', $input['email'])->first();
            $data['email'] = $input['email'];
        }
        if (!empty($input['google_token'])) {
            $data['google_token'] = $input['google_token'];
            if (empty($user_check)) {
                $user_check = User::where(['google_token' => $input['google_token']])->first();
            }
        }
        if (!empty($input['facebook_token'])) {
            $data['facebook_token'] = $input['facebook_token'];
            if (empty($user_check)) {
                $user_check = User::where(['facebook_token' => $input['facebook_token']])->first();
            }
        }
        if (!empty($input['apple_token'])) {
            $data['apple_token'] = $input['apple_token'];
            if (empty($user_check)) {
                $user_check = User::where(['apple_token' => $input['apple_token']])->first();
            }
        }
        if (!empty($input['name'])) {
            $data['name'] = $input['name'];
        }
        if (!empty($input['image'])) {
            $data['image'] = $input['image'];
        }
        if (!empty($input['notification_token'])) {
            $data['notification_token'] = $input['notification_token'];
        }
        if (!empty($input['phone_number'])) {
            $data['phone_number'] = $input['phone_number'];
        }
        if (!empty($input['device_type'])) {
            $data['device_type'] = $input['device_type'];
        }
        if (!empty($input['app_version'])) {
            $data['app_version'] = $input['app_version'];
        }
        if (!empty($input['gender'])) {
            $data['gender'] = $input['gender'];
        }
        $data['is_verified'] = 1;
        if (empty($user_check)) {
            $user_check = new User;
        } else {
            if ($user_check->status == 'Block') {
                return response()->json(['status' => 0, 'message' => 'Your account is blocked at this moment']);
            }
        }
        $user_check->fill($data);
        $user_check->save();
        $userdetail = User::find($user_check->id);
        $userdetail->token = $user_check->createToken('paradoxa')->accessToken;
        return response()->json(['status' => 1, 'message' => 'Login successfull', 'data' => $userdetail]);
    }

    public function forgot_password(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        $fields = array('email');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                }
            }
            return response()->json(['status' => 0, 'message' => $error_message]);
        }
        $emailUser = User::where('email', $data['email'])->first();
        if (empty($emailUser)) {
            return response()->json(['status' => 0, 'message' => "Email doesn't exist"]);
        }
        if (!empty($emailUser->getAttributes()['forgotpassword_token']) && ($emailUser->getAttributes()['forgotpassword_expiretime'] > strtotime('+0 hours'))) {
            $password_token = $emailUser->getAttributes()['forgotpassword_token'];
        } else {
            $password_token = rand(1000, 9999);
            User::whereId($emailUser->getAttributes()['id'])->update(['forgotpassword_token' => $password_token, 'forgotpassword_expiretime' => strtotime('+24 hours')]);
        }
        try {
            $mailResp = Mail::to([$data['email']])->send(new Forgot(['userName' => $emailUser->getAttributes()['name'], 'password_token' => $password_token], ['subject' => 'Forgot Password Mail', 'view' => 'email_template/forgot_password']));
            return response()->json(['status' => 1, 'message' => "OTP send to your mail"]);
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    /* Verify otp and reset password */

    public function verify_otp_reset(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required',
        ]);
        $fields = array('email', 'otp', 'password');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                }
            }
            return response()->json(['status' => 0, 'message' => $error_message]);
        }
        $verify_otp = User::where(['email' => $input['email'], 'forgotpassword_token' => $input['otp']])->first();
        if ($verify_otp) {
            $verify_otp->fill(['forgotpassword_token' => "", 'password' => Hash::make($input['password'])]);
            $verify_otp->save();
            return response()->json(['status' => 1, 'message' => "Password updated successfully."]);
        } else {
            return response()->json(['status' => 0, 'message' => "Wrong OTP provided."]);
        }
    }

    public function update_notification_token(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'notification_token' => 'required',
        ]);
        $fields = array('notification_token');
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
        $user->fill(['notification_token' => $input['notification_token']]);
        $user->save();
        return response()->json(['status' => 1, 'data' => "Notification token updated now"]);
    }

    public function edit_profile(Request $request)
    {
        $user = Auth::user();
        if (!empty($request->email)) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => ['required', 'email',
                    Rule::unique('users')->where(function ($query) use ($user) {
                        $query->where(['is_verified' => 1]);
                        $query->where('id', '!=', $user->id);
                    }),
                ],
                'phone_number' => 'required',
                'gender' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone_number' => 'required',
                'gender' => 'required',
            ]);
        }
        if ($request->email) {

        }
        $fields = array('name', 'email', 'phone_number', 'gender');
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

        try {
            $fillableData = ['name' => $input['name'], 'phone_number' => $input['phone_number'], 'gender' => $input['gender'], 'image' => (!empty($input['image'])) ? $input['image'] : ""];
            if (!empty($request->email)) {
                $fillableData['email'] = $input['email'];
            }

            $user->fill($fillableData);
            $user->save();

            return response()->json(['status' => 1, 'message' => 'Profile updated successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Something went wrong']);
        }
    }

    /* Check existance of email and phone */

    public function check_email_exist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email',
                Rule::unique('users')->where(function ($query) {
                    $query->where(['is_verified' => 1]);
                }),
            ],
            'phone_number' => ['required',
                Rule::unique('users')->where(function ($query) {
                    $query->where(['is_verified' => 1]);
                }),
            ],
        ]);
        $fields = array('email', 'phone_number');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                    return response()->json(['status' => 0, 'message' => $error_message]);
                }
            }
        }
        return response()->json(['status' => 1, 'message' => 'New registration.']);
    }

    public function token_status(Request $request)
    {
        $user = Auth::user();
        if ($user->status == 'Block') {
            return response()->json(['status' => 0, 'message' => "You are blocked by Admin"]);
        } elseif ($user->status == 'Active') {
            return response()->json(['status' => 1, 'message' => "User Active"]);
        }
    }
    public function deleteAccount()
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            User::where('id', $user->id)->delete();
            DB::commit();
            return response()->json(['status' => 1, 'message' => 'User account has been deleted successfully']);

        } catch (\Exception $e) {
            DB::commit();
            return response()->json(['status' => 1, 'message' => $e->getMessage()]);
        }

    }

}
