<?php

namespace App\Models\User;
use Illuminate\Database\Eloquent\Model;

class GroupModel extends Model  {
    protected $table = 'groups';
    protected $fillable = [
        'name',
        'description',
    ];

}