<?php

namespace App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model  {
    protected $table = 'users';
    protected $fillable = [
        'active',
        'username',
        'email',
        'password',
        'api_token'
    ];

}