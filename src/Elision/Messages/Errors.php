<?php

namespace Elision\Messages;


class Errors
{

    public static $errors = [];

    public static function showErrors(){
        return array_shift(self::$errors);
    }
}