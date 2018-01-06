<?php

namespace App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class Place extends Model  {
    protected $table = 'lbs_place';
    protected $fillable = [
        'id',
        'name',
        'lat',
        'lon',

    ];

}