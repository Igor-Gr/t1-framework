<?php

namespace protect\Models;

use Elision\Messages\Errors;
use Elision\Orm\Model;

class Login
    extends Model
{

    public $login;
    public $password;

    public function setting()
    {
        return [
            [['login', 'password'], 'required', 'login' => 'Логин', 'password' => 'Пароль'],
            ['login', 'validatePassword']
        ];
    }

    public function validatePassword()
    {
        $user = $this->getUser();

        if (!$user || $user->password != sha1($this->password)) {
            Errors::$errors[] = 'Логин или пароль введены не верно';
            return false;
        }
    }

    public function getUser()
    {
        $user = new Users();
        return $user->find()->where(['login' => $this->login])->all();
    }
}