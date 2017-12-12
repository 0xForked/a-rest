<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CrudModel extends Model  {
    protected $table = 'rest_crud';
    protected $fillable = [
        'data',

    ];

}