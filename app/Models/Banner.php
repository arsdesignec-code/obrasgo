<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = "banners";
    // public $timestamps = false;

    public function categoryname(){
        return $this->hasOne('App\Models\Category','id','category_id')->select('id','name');
    }
    public function servicename(){
        return $this->hasOne('App\Models\Service','id','service_id')->select('id','name');
    }
}
