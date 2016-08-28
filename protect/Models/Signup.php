<?php

namespace protect\Models;


use Elision\Helpers\Helpers;
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
            [['login', 'email'], 'unique', 'table' => 'users', 'email' => 'Е-маил', 'login' => 'Логин']

        ];
    }

    public function signup()
    {
        $users = new Users();
        $balance = new Balance();
        $config = new Config();

        $clientId = Helpers::uniqueId(8);

        $users->login = $this->login;
        $users->email = $this->email;
        $users->setPassword($this->password);
        $users->client_id = $clientId;

        $balance->client_id = $clientId;

        $config->client_id = $clientId;

        if ($users->save() && $balance->save() && $config->save()) return true;
        else return false;
    }

}