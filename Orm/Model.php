<?php

namespace Orm;


abstract class Model
{

    /**
     * @var \PDO
     */
    static protected $connection;

    /**
     * @return \PDO
     */
    public static function getDbConnection()
    {
        if (static::$connection == null) {
            static::$connection = new \Dbal\Connection(new \Core\Config('protect/config.php'));
        }
        return static::$connection;
    }
}