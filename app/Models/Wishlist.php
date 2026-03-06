<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';
    protected $fillable = ['user_id', 'service_id'];

    public function rattings()
    {
        return $this->hasMany('App\Models\Rattings', 'service_id', 'id');
    }
    
    public function service_multi_image()
    {
        return $this->hasMany('App\Models\GalleryImages', 'service_id', 'id');
    }
}
