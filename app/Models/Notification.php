<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = "notification";
    // public $timestamps = false;

    public function usersname(){
        return $this->hasOne('App\Models\User','id','user_id')->select('id','name');
    }
}
