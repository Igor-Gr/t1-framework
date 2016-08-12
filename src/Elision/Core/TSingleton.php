<?php

namespace Elision\Core;

trait TSingleton
//implements ISingleton
{

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    /**
     * @param bool $new
     * @return static
     */
    public static function instance()
    {
        static $instance = null;
        if (null === $instance)
            $instance = new static;
        return $instance;
    }

}