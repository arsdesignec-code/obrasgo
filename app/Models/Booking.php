<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = "bookings";
    // public $timestamps = false;

    public function servicename()
    {
        return $this->hasOne('App\Models\Service', 'id', 'service_id')->select('id', 'name');
    }
    public function providername()
    {
        return $this->hasOne('App\Models\Provider', 'id', 'provier_id')->select('id', 'fname', 'lname');
    }
    public function handymanname()
    {
        return $this->hasOne('App\Models\Handyman', 'id', 'handyman_id')->select('id', 'fname', 'lname');
    }
    public function usersname()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->select('id', 'name', 'email', 'mobile');
    }
}
