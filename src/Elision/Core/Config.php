<?php

namespace Elision\Core;

class Config
    extends Std
{
    
    public static $init;
    
    /**
     * @param array|string|null $data
     * @throws \Elision\Core\Exception
     * @property $path string
     */
    public function __construct($data = null)
    {
        if ($data !== null) {
            if (is_array($data)) {
                parent::__construct($data);
            } else {
                $this->load((string)$data);
            }
        }
    }

    /**
     * @param string $path
     * @return \Elision\Core\Config
     * @throws \Elision\Core\Exception
     */
    public function load($path)
    {
        if (!is_readable($path)) {
            throw new Exception('Config file ' . $path . ' is not found or is not readable');
        }

        return $this->fromArray(include($path));
    }
    
    public static function getConfig()
    {
        if (self::$init == null)
            self::$init = new Config('protect/config.php');
        return self::$init;
    }
}