<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Help extends Model
{

   protected $table = "help";
   // public $timestamps = false;

   public function usersname(){
      return $this->hasOne('App\Models\User','id','user_id')->select('id','name');
   }
}

