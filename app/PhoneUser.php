<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class PhoneUser extends Model {

    protected $guarded = [
    ];

    public function mobile($user_id = null) {
        return PhoneUser::where(['type' => 'mobile', 'user_id' => $user_id])->get();
    }

    public function landline($user_id = null) {
        return PhoneUser::where(['type' => 'landline', 'user_id' => $user_id])->get();
    }

    public function sms($user_id = null) {
        return PhoneUser::where(['type' => 'sms', 'user_id' => $user_id])->get();
    }

    public function whatsapp($user_id = null) {
        return PhoneUser::where(['type' => 'whatsapp', 'user_id' => $user_id])->get();
    }

    public function fax($user_id = null) {
        return PhoneUser::where(['type' => 'fax', 'user_id' => $user_id])->get();
    }

    public function other($user_id = null) {
        return PhoneUser::where(['type' => 'other', 'user_id' => $user_id])->get();
    }

}
