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

# load composer
require "vendor/autoload.php";

class LoginController extends Controller {

    public function __construct() {

    }

    public function reset_password($token) {
        $userDetail = User::where(['forgotpassword_token' => $token])->first();
        if (isset($userDetail->forgotpassword_token)) {
            if ($userDetail->forgotpassword_expiretime > strtotime('+0 hours')) {
                return view('forgot/reset_password', ['userDetail' => $userDetail, 'token' => $token]);
            } else {
                return view('static_pages/invalid_link');
            }
        } else {
            return view('static_pages/invalid_link');
        }
    }

    public function reset_password_submit(Request $request) {
        $this->validate($request, [
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);
        $input = $request->all();
        $userDetail = User::where('forgotpassword_token', $input['forgot_token'])->first();
        if ($userDetail) {
            $modal = User::find($userDetail->id);
            $modal->fill(['password' => Hash::make($input['password']), 'forgotpassword_token' => '', 'forgotpassword_expiretime' => '0']);
            if ($modal->save()) {
                return redirect()->route('password_success');
            }
        } else {
            return view('static_pages/invalid_link');
        }
    }

    public function invalid_link() {
        return view('static_pages/invalid_link');
    }

    public function page_not_found() {
        return view('static_pages/page_not_found');
    }

    public function password_success(){
        return view('static_pages/password_changed');
    }

}
