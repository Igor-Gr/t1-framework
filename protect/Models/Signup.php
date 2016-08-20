<?php

namespace protect\Models;


use Elision\Orm\Model;

class Signup
    extends Model
{

    public $login;
    public $email;
    public $password;
    public $password_2;

    public function setting()
    {
        return [

            [['login', 'email', 'password'], 'required', 'login' => 'Логин', 'email' => 'Е-маил', 'password' => 'Пароль'],
            ['login', 'string', 'min' => 5, 'max' => 10, 'login' => 'Логин'],
            ['email', 'email'],
            ['password', 'string', 'min' => 6, 'max' => 10, 'password' => 'Пароль'],
            [['password', 'password_2'], 'coincidence', 'fields' => 'Пароли'],
            ['login', 'unique'],
            ['email', 'unique']

        ];
    }

    public function signup()
    {
        
    }

}