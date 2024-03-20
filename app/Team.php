<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model {

    use SoftDeletes;

    protected $guarded = [
    ];

    public function players(){
        return $this->hasManyThrough('App\Player','App\TeamPlayer','team_id','id','id','player_id');
    }

}
