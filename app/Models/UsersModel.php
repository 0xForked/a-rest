<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model  {
    protected $table = 'rest_user';
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    public function setPassword($password){

        $this->update([
            'password' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 10])
        ]);

    }

}