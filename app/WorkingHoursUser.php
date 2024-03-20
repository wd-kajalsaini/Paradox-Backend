<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class WorkingHoursUser extends Model {

    protected $guarded = [
    ];

    public function Sunday($user_id = null) {
        return WorkingHoursUser::select('from_time','until_time')->where(['day' => 'Sunday', 'user_id' => $user_id])->get();
    }

    public function Monday($user_id = null) {
        return WorkingHoursUser::select('from_time','until_time')->where(['day' => 'Monday', 'user_id' => $user_id])->get();
    }

    public function Tuesday($user_id = null) {
        return WorkingHoursUser::select('from_time','until_time')->where(['day' => 'Tuesday', 'user_id' => $user_id])->get();
    }

    public function Wednesday($user_id = null) {
        return WorkingHoursUser::select('from_time','until_time')->where(['day' => 'Wednesday', 'user_id' => $user_id])->get();
    }

    public function Thursday($user_id = null) {
        return WorkingHoursUser::select('from_time','until_time')->where(['day' => 'Thursday', 'user_id' => $user_id])->get();
    }

    public function Friday($user_id = null) {
        return WorkingHoursUser::select('from_time','until_time')->where(['day' => 'Friday', 'user_id' => $user_id])->get();
    }

    public function Saturday($user_id = null) {
        return WorkingHoursUser::select('from_time','until_time')->where(['day' => 'Saturday', 'user_id' => $user_id])->get();
    }

}
