<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

    protected $guarded = [
    ];

    public function group_members() {
        return $this->hasMany('App\GroupContact', 'group_id', 'id');
    }

    public function owner(){
        return $this->hasOne('App\User','id','owner_id');
    }

}
