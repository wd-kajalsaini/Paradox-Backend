<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BusinessUser extends Model {

    protected $guarded = [
    ];

    public function business_logo($user_id = null) {
        return BusinessUser::where(['title' => 'business_logo', 'user_id' => $user_id])->first();
    }

}
