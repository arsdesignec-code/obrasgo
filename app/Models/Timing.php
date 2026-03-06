<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timing extends Model
{
    protected $table = "timings";
    protected $fillable=['day','opentime','closetime','always_close'];
    // public $timestamps = false;

    public function providername(){
        return $this->hasOne('App\Models\User','id','provider_id')->select('id','name');
    }
}
