<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class SubscribedShow extends Model {

    protected $guarded = [
    ];

    public function users(){
        return $this->hasMany('App\User','id','user_id');
    }

}
