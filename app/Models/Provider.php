<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Provider extends Model
{
    protected $table = "providers";
    // public $timestamps = false;

    public function providertype(){
        return $this->hasOne('App\Models\ProviderType','id','provider_type_id')->select('id','name');
    }
    public function city(){
        return $this->hasOne('App\Models\City','id','city_id')->select('id','name');
    }
    public function rattings(){
        return $this->hasMany('App\Models\Rattings','provider_id','id')->select('provider_id',DB::raw('ROUND(AVG(ratting),1) as avg_ratting'))->groupBy('provider_id');
    }
}
