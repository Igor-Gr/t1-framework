<?php

namespace Fs;


class Helpers
{

    public static function makeDir($dirName, $mode = 0777)
    {
        if (file_exists($dirName) && is_dir($dirName)) {
            return chmod($dirName, $mode);
        }
        $result = mkdir($dirName, $mode, true);
        
        return true;
    }
}