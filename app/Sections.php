<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Sections extends Model
{
    protected $table = 'sections';

    protected $guarded = [

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    // public function subSections()
    // {
    //     return $this->hasMany('App\Sections',);
    // }
    public function permission()
    {
        return $this->belongsTo(Permissions::class,'id','section_id');
    }
    public function subSections()
    {
        return $this->hasMany(Sections::class,'parent_id','id')->with('subSections');
    }
    public function managerPermission()
    {
        return $this->belongsTo(Permissions::class,'id','section_id');
    }




}
