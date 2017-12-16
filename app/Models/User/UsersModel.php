<?php

namespace App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model  {
    protected $table = 'users';
    protected $fillable = [
        'email',
        'username',
        'password',
        'api_token',
        'active'
    ];

    public function setPassword($password){

        $this->update([
            'password' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 10])
        ]);

    }

}