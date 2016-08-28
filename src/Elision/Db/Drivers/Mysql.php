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

        if (method_exists($model, tableName)) {
            $tableName = $model->tableName();
        } else {
            $tableName = $model->getClassName();
        }

        $pdoFields = [];
        $pdoValues = [];

        $columns = '';
        $sets = '';

        foreach ($model as $k => $v) {
            if (empty($v)) continue;
            $sets .= ':' . $k . ',';
            $columns .= $k . ',';
            $pdoFields[] = $k;
            $pdoValues[] = $v;
        }
        $sets = substr($sets, 0, -1);
        $columns = substr($columns, 0, -1);

        $values = '('. $columns .') VALUES ('. $sets .')';


        $pdoData = $this->psrsePdoArray($pdoFields, $pdoValues);

        $connection = \Elision\Orm\Model::getDbConnection();

        $sql = new QueryBuilder();
        $sql->insert($tableName)
            ->values($values);
        return $connection->execute($sql, $pdoData);
    }

    public function save($model)
    {
       return $this->saveColumns($model);
    }
    
    public function update($model, $options)
    {
        $model->deleteWorkingPropertys($model);

        $modelFields = $this->parseModelProperties($model);
        $tableName = $model->getClassName();
        $parseOptions = $model->parseQuery($options);


        $sql = 'UPDATE ' . $tableName . ' SET ' . $modelFields['fields'] . ' WHERE ' . $parseOptions['fields'];

        $connection = \Elision\Orm\Model::getDbConnection();
        
        $result = $connection->execute($sql, array_merge($modelFields['pdo'], $parseOptions['pdo']));

        return $result;
    }

    /**
     * Парсит свойства модели и если у свойства есть значение возращает их в стиле PDO
     *
     * Возвращает массив с двумя массивами, первый имена свойств (они же имена полей в таблице) ['имя=:имя'],
     * второй PDO массив подстановок [':имя' => значение]
     *
     * @param $model
     * @return array
     */
    public function parseModelProperties($model)
    {
        $fields = '';
        $pdo = [];

        foreach ($model as $field => $value) {
            if (empty($value)) continue;
            $fields .= $field . '=:' . $field . ',';
            $pdo[':'.$field] = $value;
        }

        $fields = substr($fields, 0, -1);

        return [
            'fields' => $fields,
            'pdo' => $pdo
        ];
    }

    public function all($connection, $sql, $model, $asArray, $pdo = [])
    {
        if ($asArray == true) {
            if (isset($pdo)) $result = $connection->query($sql, $pdo);
            else $result = $connection->query($sql);
        } else {
            if (isset($pdo)) $result = $connection->queryClass($sql, $model, $pdo);
            else $result = $connection->queryClass($sql, $model);
        }
        if (!empty($result[0]) && empty($result[1])) {
            return $result[0] ?: [];
        } else {
            return $result ?: [];
        }
    }

}