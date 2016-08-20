<?php

namespace Elision\Helpers;


class Html
{

    public static function submitButton($value, $options = [])
    {
        $attributes = self::parseOptions($options);
        
        $tag = "<button ". $attributes ." >" . $value . "</button>";
        return $tag;
    }

    /**
     * Парсит атрибуты тега
     *
     * @param $options
     * @return string
     */
    public static function parseOptions($options)
    {
        $getOptions = '';

        foreach ($options as $k => $v) {
            $getOptions .= $k . '=' . '"' . $v . '"' . ' ';
        }
        $getOptions = substr($getOptions, 0, -1);
        return $getOptions;
    }
}