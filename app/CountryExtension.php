<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class CountryExtension extends Model {
    
    use SoftDeletes;

    protected $guarded = [
    ];

}
