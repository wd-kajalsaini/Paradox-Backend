<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model {

    use SoftDeletes;

    protected $guarded = [
    ];

}
