<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;



class Service extends Model

{

    protected $table = "services";

    // public $timestamps = false;



    public function providername()
    {

        return $this->hasOne('App\Models\User', 'id', 'provider_id')->select('id', 'name');
    }

    public function categoryname()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id')->select('id', 'name');
    }

    public function rattings()
    {
        return $this->hasMany('App\Models\Rattings', 'service_id', 'id');
    }

    public function service_multi_image()
    {
        return $this->hasMany('App\Models\GalleryImages', 'service_id', 'id');
    }

    public function api_rattings()
    {
        return $this->hasMany('App\Models\Rattings', 'service_id', 'id')->select('service_id', DB::raw('ROUND(AVG(ratting),1) as avg_ratting'))->groupBy('service_id');
    }
    public function wishlist()
    {
        return $this->belongsTo(WishList::class, 'id', 'service_id');
    }
}
