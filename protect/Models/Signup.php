<?php

namespace protect\Models;


use Elision\Orm\Model;

class Signup
    extends Model
{

    public $login;
    public $email;
    public $password;

    public function setting()
    {
        return [

            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'string', 'min' => 5, 'max' => 10]

        ];
    }

    public function signup()
    {
        
    }

}