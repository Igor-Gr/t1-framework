<?php

namespace Elision\Helpers;


class Helpers
{

    /**
     * Создает уникальный набор символов с указаной длиной
     * 
     * @param $length
     * @return string
     */
    public static function uniqueId($length)
    {
        return substr(uniqid(), - $length);
    }
}