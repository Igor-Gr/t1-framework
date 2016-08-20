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
            ['login', 'string', 'min' => 5, 'max' => 10, 'field' => 'Логин'],
            ['email', 'email'],
            ['password', 'string', 'min' => 6, 'max' => 10, 'field' => 'Пароль']

        ];
    }

    public function signup()
    {
        
    }

}