<?php

namespace Elision\Http;


class Helpers
{

    public static function setCookie()
    {
        
    }

    /**
     * @param string $name
     * @return bool
     */
    public static function issetCookie($name)
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public static function getCookie($name)
    {
        return $_COOKIE($name);
    }
}