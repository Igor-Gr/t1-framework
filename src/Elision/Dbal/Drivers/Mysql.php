<?php

namespace Elision\Dbal\Drivers;

use Elision\Dbal\Connection;
use Elision\Dbal\IDriver;

class Mysql
    implements IDriver
{
    /**
     * @param $name string
     * @param $options array
     * @return string
     */
    protected function createColumnDDL($name, $options)
    {
        switch ($options['type']) {
            case 'serial':
                $ddl = 'SERIAL';
                break;
            case 'int':
                $ddl = 'INTEGER';
                break;
        }

        return $name . ' ' . $ddl;

    }

    protected function crateTableDDL($tableName, $columns = [], $indexes = [], $extensions = [])
    {
        $sql = 'CREATE TABLE ' . $tableName;

        $columnsDDL = [];
        $indexesDDL = [];

        foreach ($columns as $k => $v) {
            $columnsDDL[] = $this->createColumnDDL($k, $columns[$k]);
        }

        $sql .= "(" .
            implode(",", array_unique($columnsDDL)) .
            ")";
        return $sql;

    }

    public function createTable(Connection $connection, $tableName, $columns = [], $indexes = [], $extensions = [])
    {
        $connection->execute($this->crateTableDDL($tableName, $columns, $indexes, $extensions));
        //return $this->crateTableDDL($tableName, $columns, $indexes, $extensions);
    }

    public function existsTable(Connection $connection, $tableName)
    {
        $sql = 'SHOW TABLES LIKE \'' . $tableName . '\'';
        $result = $connection->query($sql);
        return $result == [] ? false : true;
    }
}