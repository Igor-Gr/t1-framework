<?php

namespace Elision\Http;


class Response
{
    
    
    public static function redirect($url)
    {
        header("Location: " . $url);
    }
}