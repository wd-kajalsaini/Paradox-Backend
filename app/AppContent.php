<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class AppContent extends Model {

    protected $guarded = [
    ];

    function fieldData() {
        return $this->hasOne('App\AppContentField', 'app_content_id', 'id');
    }

}
