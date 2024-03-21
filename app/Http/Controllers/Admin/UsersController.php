<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Managers;
use DB;
use App\Permissions;
use App\Sections;
use Route;
use App\ManagerTypes;
use Auth;
use Storage;
use Hash;
use File;
use App\Dictionary;
use App;
use Cookie;
use App\User;
use App\Inbox;
use Illuminate\Validation\Rule;
use Validator;

class UsersController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth');
    }

    /* Retrieve all the application users */

    public function index() {
        $data['page_title'] = 'Application Users';
        $data['link'] = 'Application_Users';
        $data['userListing'] = User::where(['is_verified' => 1])->get();
        return view('users.index', $data);
    }

    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'email' => ['required','email',
                        Rule::unique('users')->where(function($query) {
                            $query->where(['is_verified' => 1]);
                            })
                        ],
                        'password' => 'required',
                        'phone_number' => 'required',
                        'gender' => 'required'
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
            if (!$userData) {
                $userData = new User();
            }
            try {
                $input['password'] = Hash::make($input['password']);
                $input['is_verified'] = 1;
                if (!empty($request->file('avatar'))) {
                    $avatar_icon = $request->file('avatar');
                    $avatar_iconFileName = str_replace(" ", "", str_replace(".", "", microtime())) . '.' . $avatar_icon->getClientOriginalExtension();
                    $avatar_icondb = "https://paradox1.s3.ap-south-1.amazonaws.com/users/" . $avatar_iconFileName;

                    $s3 = \Storage::disk('s3');
                    $filePath = '/users/' . $avatar_iconFileName;
                    $avatar_icon_image = $s3->put($filePath, file_get_contents($avatar_icon), 'public');
                    $input['image'] = $avatar_icondb;
                }
                // $fourdigitrandom = rand(1000,9999);
                // $input['email_verification_code'] = $fourdigitrandom;
                $fillableData = collect($input)->forget(['_token', '_method','avatar'])->toArray();
                $userData->fill($fillableData);
                $userData->save();
                // $mailResp = Mail::to([$input['email']])->send(new Forgot(['email_verification_code' => $fourdigitrandom, 'userName' => $input['name']], ['subject' => 'Email Verification Code', 'view' => 'email_template/email_verification']));
                \Session::flash('message', 'User registered successful');
                \Session::flash('class', 'success');
                return response()->json(['status' => 1, 'message' => 'User registered successful']);
            } catch (Exception $e) {
                return response()->json(['status' => 0, 'message' => 'Something went wrong']);
            }
        }
        $data['page_title'] = 'Application Users';
        $data['link'] = 'Application_Users';

        return view('users.add', $data);
    }

    public function view($id, Request $request) {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'email' => ['required','email',
                        Rule::unique('users')->where(function($query)use($id) {
                            $query->where(['is_verified' => 1]);
                            $query->where('id','!=',$id);
                            })
                        ],
                        'gender' => 'required'
            ]);
            $fields = array('name', 'email', 'gender');
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
            if (isset($input['general_form_submit'])) {
                try {
                    $userDetail = User::find($id);
                    if(!empty($input['email'])){
                        $existEmail = User::where(['email' => $input['email']])->where('id', '!=', $id)->first();
                        if ($existEmail) {
                            return response()->json(['status' => 0, 'message' => "Email already exist for another user"]);
                        }
                    }
                    if (!empty($request->file('avatar'))) {
                        $avatar_icon = $request->file('avatar');
                        $avatar_iconFileName = str_replace(" ", "", str_replace(".", "", microtime())) . '.' . $avatar_icon->getClientOriginalExtension();
                        $avatar_icondb = "https://paradox1.s3.ap-south-1.amazonaws.com/users/" . $avatar_iconFileName;


                        $s3 = \Storage::disk('s3');
                        $filePath = '/users/' . $avatar_iconFileName;
                        $avatar_icon_image = $s3->put($filePath, file_get_contents($avatar_icon), 'public');
                        $input['image'] = $avatar_icondb;
                    }
                    $newDataField = collect($input)->forget(['_token', '_method', 'general_form_submit','avatar'])->toArray();
                    $userDetail->fill($newDataField);
                    $userDetail->save();
                    \Session::flash('message', 'Info updated successfully');
                    \Session::flash('class', 'success');
                    return response()->json(['status' => 1, 'message' => "Info updated successfully"]);
                } catch (Exception $e) {
                    return response()->json(['status' => 0, 'message' => 'Something went wrong']);
                }
            }
        }
        $data['page_title'] = 'Application Users';
        $data['link'] = 'Application_Users';
        $data['userDetail'] = User::find($id);
        return view('users.view', $data);
    }

    /* Delete User */

    public function delete(Request $request, $id) {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            User::destroy($id);
            $managerObject = new Managers;
            $admin_session = $managerObject->create_qb_session(['login' => QB_ADMIN_USERNAME,'password' => QB_ADMIN_PASSWORD]);
            $quickBloxUser = $managerObject->retreive_api_user_by_login($admin_session->session->token,$user->email);
            if(!empty($quickBloxUser->user)){
                $managerObject->delete_qb_user($admin_session->session->token,$quickBloxUser->user->id);
            }
            DB::commit();
            if(!empty($user->notification_token)){
                $response = $this->send_notification('Account deleted','Your account is deleted by an admin.',[$user->notification_token],['type' => 'account_deleted']);
            }
            \Session::flash('message', 'User Deleted Successfully!');
            \Session::flash('class', 'success');
            return response()->json(['status' => 1, 'message' => "User Deleted Successfully"]);
        } catch (\PDOException $e) {
            // Woopsy
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    /* Active Block User */

    public function active_block($id, Request $request) {
        $user = collect($request->all())->forget(['_token', '_method'])->toArray();
        $modal = User::find($id);
        $modal->fill($user);
        if ($modal->update()) {
            if ($request->all()['status'] == 'Active') {
                return response()->json(['status' => 1, 'message' => "User active now", 'response_status' => 'Active']);
            } else {
                if(!empty($modal->notification_token)){
                    $response = $this->send_notification('You are blocked','You are blocked by an admin.',[$modal->notification_token],['type' => 'user_block']);
                }
                return response()->json(['status' => 1, 'message' => "User block now", 'response_status' => 'Block']);
            }
        }
    }

    public function send_notification($heading = "", $content = "", $include_player_ids, $data) {
        $contents = array(
            "en" => $content
        );
        $headings = array(
            "en" => $heading
        );
        $fields = array(
            'app_id' => ONESIGNALAPPID,
            'data' => $data,
            'contents' => $contents
        );
        if(!empty($heading)){
            $fields['headings'] = $headings;
        }
        if ($include_player_ids == 'subscribed_users') {
            $fields['included_segments'] = ['All'];
        } else {
            $fields['include_player_ids'] = $include_player_ids;
        }


        $fields = json_encode($fields);
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                'Authorization: Basic ' . ONESIGNALAUTHORIZATIONKEY));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
            curl_close($ch);

            return json_decode($response);
        } catch (Exception $e) {

        }
    }

}
