<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Show extends Model {

    use SoftDeletes;

    protected $guarded = [
    ];

    protected $appends = ['is_live'];

    public function subscribed_users(){
        return $this->hasManyThrough(
            'App\User',
            'App\SubscribedShow',
            'show_id', // Foreign key on users table...
            'id', // Foreign key on posts table...
            'id', // Local key on countries table...
            'user_id' // Local key on users table...
        );
    }

    public function show_questions(){
        return $this->hasMany('App\ShowQuestion');
    }

    public function subscribers(){
        return $this->belongsToMany('App\User','subscribed_shows','show_id','user_id');
    }

    public function getIsLiveAttribute(){
        if((is_null($this->stop_at)) && !(is_null($this->live_at))){
            return 1;
        } else {
            return 0;
        }
    }

}
