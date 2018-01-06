<?php

namespace App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class LocationCity extends Model  {
    protected $table = 'lbs_city';
    protected $fillable = [
        'id',
        'name',
    ];

}