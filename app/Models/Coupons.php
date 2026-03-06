<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Coupons extends Model
{
    protected $table = "coupons";
    // public $timestamps = false;

    public function servicename()
    {
        return $this->hasOne('App\Models\Service', 'id', 'service_id')->select('id', 'name');
    }
}
