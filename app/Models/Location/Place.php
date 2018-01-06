<?php

namespace App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class Place extends Model  {
    protected $table = 'lbs_place';
    protected $fillable = [
        'id',
        'location_id',
        'category_id',
        'name',
        'lat',
        'lon',

    ];

}