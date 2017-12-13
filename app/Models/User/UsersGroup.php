<?php

namespace App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UsersGroup extends Model  {
    protected $table = 'users_group';
    protected $fillable = [
        'user_id',
        'group_id',
    ];

}