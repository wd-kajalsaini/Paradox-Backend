<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

    protected $table = 'users';
    protected $guarded = [
    ];

//    public function contact_detail() {
//        return $this->belongsToMany('App\Contact', 'kvitel_contacts', 'user_id', 'contact_id');
//    }
    
}
