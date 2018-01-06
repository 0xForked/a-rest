<?php

namespace App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class LocationStates extends Model  {
    protected $table = 'lbs_states';
    protected $fillable = [
        'id',
        'name',
    ];

}