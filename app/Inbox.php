<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Inbox extends Model {

    protected $guarded = [
    ];

    public function sender() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
