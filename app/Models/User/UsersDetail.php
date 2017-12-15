<?php

namespace App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UsersDetail extends Model  {
    protected $table = 'users_detail';
    protected $fillable = [
        'user_id',
        'name',
        'phone'
    ];

}