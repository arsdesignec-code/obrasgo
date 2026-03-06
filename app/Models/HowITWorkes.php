<?php

namespace  App\Models;

use Illuminate\Database\Eloquent\Model;

class HowITWorkes extends Model
{
    protected $table = 'how_it_works';
    protected  $fillable = ['how_it_works_title', 'how_it_works_image', 'how_it_works_description'];
}
