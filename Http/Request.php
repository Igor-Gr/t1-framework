<?php

namespace Http;


class Request
{

    public static function originRequest()
    {
        $headers = getallheaders();
        if (isset($headers['Origin'])) {
            return header('Access-Control-Allow-Origin: ' . $headers['Origin']);
        }
    }

    public static function getIp()
    {
        if (isset($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        } else {
            return false;
        }
    }
}