<?php

namespace Elision\Orm;


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
            static::$connection = new \Elision\Dbal\Connection(new \Elision\Core\Config('protect/config.php'));
        }
        return static::$connection;
    }
}