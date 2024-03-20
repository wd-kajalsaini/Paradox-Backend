<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ShowBanner extends Model {

    protected $guarded = [
    ];

    public function show(){
        return $this->belongsTo('App\Show');
    }

    public function show_list(){
        return $this->belongsTo('App\Show','show_id','id');
    }

}
