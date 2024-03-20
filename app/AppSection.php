<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppSection extends Model {

    use SoftDeletes;

    protected $guarded = [
    ];

    public function shows(){
        return $this->hasMany('App\SectionShowLink','section_id','id');
    }

    public function show_list(){
        return $this->hasManyThrough('App\Show','App\SectionShowLink','section_id','id','id','show_id')->orderBy('section_show_links.sort_order');
    }

    public function limitRelationship(string $name, int $limit){
        $this->relations[$name] = $this->relations[$name]->slice(0, $limit);
    }

}
