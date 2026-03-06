<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Handyman extends Model
{
    protected $table = "handyman";
    // public $timestamps = false;

    public function providername(){
        return $this->hasOne('App\Models\Provider','id','provider_id')->select('id','fname','lname');
    }
    public function city(){
        return $this->hasOne('App\Models\City','id','city_id')->select('id','name');
    }
}
