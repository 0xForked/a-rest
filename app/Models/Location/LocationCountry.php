<?php

namespace App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class LocationCountry extends Model  {
    protected $table = 'lbs_country';
    protected $fillable = [
        'id',
        'name',
    ];

}