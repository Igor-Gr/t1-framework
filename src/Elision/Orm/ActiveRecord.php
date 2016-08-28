<?php

namespace Elision\Orm;

use Elision\Db\QueryBuilder;

class ActiveRecord
    extends QueryBuilder
{


    public function save()
    {
        $connection = \Elision\Orm\Model::getDbConnection();
        return $connection->getDriver()->save($this);
    }
    
    public function update($options)
    {
        $connection = \Elision\Orm\Model::getDbConnection();
        return $connection->getDriver()->update($this, $options);
    }

    public static function getClassName()
    {
        $class = static::class;
        $class = explode('\\', $class);
        return array_pop($class);
    }

}