<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingAddress extends Model
{
    protected $table = "booking_addresses";
    // public $timestamps = false;

    public function usersname(){
        return $this->hasOne('App\Models\User','id','user_id')->select('id','name');
    }
}
