<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transactions";

    public function usersname(){
        return $this->hasOne('App\Models\User','id','user_id')->select('id','name');
    }
    public function servicename(){
        return $this->hasOne('App\Models\Service','id','service_id')->select('id','name');
    }
    public function providername(){
        return $this->hasOne('App\Models\User','id','provider_id')->select('id','name');
    }
}
