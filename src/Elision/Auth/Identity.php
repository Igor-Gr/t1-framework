<?php

namespace Elision\Auth;

use Elision\Core\Session;

class Identity
{

    public static function login(IdentityInterface $user)
    {
        Session::set('logged_user', $user->login);
        Session::set('client_id', $user->client_id);
    }

    public static function logout(IdentityInterface $user)
    {
        Session::unseted($user->login);
        Session::unseted($user->client_id);
    }
}