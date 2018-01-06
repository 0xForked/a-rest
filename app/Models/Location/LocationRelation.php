<?php

namespace App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class LocationRelation extends Model  {
    protected $table = 'lbs_location_relation';
    protected $fillable = [
        'id',
        'country_id',
        'states_id',
        'city_id',

    ];

}