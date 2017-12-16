<?php

namespace App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UsersDetail extends Model  {
    protected $table = 'users_details';
    protected $fillable = [
        'user_id',
        'full_name',
        'phone'
    ];

}