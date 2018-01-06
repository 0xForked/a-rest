<?php

namespace App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class PlaceCategory extends Model  {
    protected $table = 'lbs_place_category';
    protected $fillable = [
        'id',
        'category_name',

    ];

}