<?php

namespace App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class PlaceRelation extends Model  {
    protected $table = 'lbs_place_relation';
    protected $fillable = [
        'id',
        'location_relation_id',
        'place_category_id',
        'place_id',

    ];

}