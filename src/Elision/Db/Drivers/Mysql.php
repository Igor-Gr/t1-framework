<?php

namespace Elision\Db\Drivers;

use Elision\Db\Connection;
use Elision\Db\IDriver;
use Elision\Db\QueryBuilder;

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

    public function findAllByQuery(Connection $connection, $query, $tableName, $row)
    {
        $sql = 'SELECT * FROM ' . $tableName . ' WHERE ' . $row . '=:' . $row;
        $result = $connection->query($sql, [':' . $row => $query]);
        return $result == [] ? false : $result;
    }

    public function insertInTable(Connection $connection, $tableName, $fields, $values)
    {
        $sql = 'INSERT INTO ' . $tableName . ' (' . implode(",", $fields) .') VALUES (' . $this->parsePdoFields($fields, $values) . ')';
        $result = $connection->execute($sql, $this->psrsePdoArray($fields, $values));
        return $result ?: false;
    }

    protected function parsePdoFields($fields, $values)
    {
        $parseFields = '';

        foreach ($fields as $v) {
            $parseFields .= ':' . $v . ',';
        }

        $parseFields = substr($parseFields, 0, -1);

        return $parseFields;
    }

    protected function psrsePdoArray($fields, $values)
    {
        $pdoStr = '';
        $pdoArray = [];

        for ($i = 0; $i < count($fields); $i++) {
            $pdoStr .= ':' . $fields[$i] . '-' . $values[$i] . '|';
        }

        $pdoStr = substr($pdoStr, 0, -1);

        $data = explode('|', $pdoStr);

        foreach($data as $a) {
            $v = explode('-',$a);
            $pdoArray[array_shift($v)] = array_pop($v);
        }

        return $pdoArray;
    }

    public function saveColumns($model)
    {
        $pdoFields = [];
        $pdoValues = [];

        $colums = '';
        $sets = '';

        foreach ($model as $k => $v) {
            $sets .= ':' . $k . ',';
            $colums .= $k . ',';
            $pdoFields[] = $k;
            $pdoValues[] = $v;
        }
        $sets = substr($sets, 0, -1);
        $colums = substr($colums, 0, -1);

        $values = '('. $colums .') VALUES ('. $sets .')';


        $pdoData = $this->psrsePdoArray($pdoFields, $pdoValues);

        $connection = \Elision\Orm\Model::getDbConnection();

        $sql = new QueryBuilder();
        $sql->insert($model->getClassName())
            ->values($values);
        $connection->execute($sql, $pdoData);
    }

    public function save($model)
    {
        $this->saveColumns($model);
    }

}