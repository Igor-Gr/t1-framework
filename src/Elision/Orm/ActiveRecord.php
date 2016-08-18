<?php

namespace Elision\Orm;

use Elision\Db\QueryBuilder;


class ActiveRecord
{


    public function save()
    {
        $class = get_class($this);
        $connection = \Elision\Orm\Model::getDbConnection();
        $connection->getDriver()->save($this);
    }

    public function getClassName()
    {
        $class = static::class;
        $class = explode('\\', $class);
        return array_pop($class);
    }

    public function getFieldsValues()
    {
        $values = [];

        foreach ($this as $value) {
            if ($value == 'SELECT *') break;
            $values[] = $value;
        }
        return $values;
    }

    public function getFields()
    {
        $fields = [];

        foreach ($this as $key => $value) {
            if ($key == '_select') break;
            $fields[] = $key;
        }
        return $fields;
    }

    public function insert()
    {

    }

    public function selectAll($class = null)
    {
        $connection = \Elision\Orm\Model::getDbConnection();

        $sql = new QueryBuilder();
        $sql->select('*', $this->getClassName());

        if ($class == 'Class'){
            $result = $connection->queryClass('SELECT * FROM user', static::class);
            return $result;
        } else {
            $result = $connection->query('SELECT * FROM user');
            return $result;
        }
    }

    /**
     * Возвращает данные с БД с условием, в виде массива или обьекта класса.
     *
     * Принимает массив вида ['поле' => 'чему равно'], вторым не обязательным параметром
     * принимает строку 'Class', которая означает, что данные будут возвращенны не в виде массива,
     * а в виде обьекта класса.
     *
     * @param array $condition
     * @param null|string $class
     * @return \PDOStatement
     */
    public function findByCondition($condition, $class = null)
    {
        $table = $this->getClassName();
        $conditions = '';
        $pdoArray = [];

        foreach ($condition as $k => $v) {
            $conditions .= $k . '=:' . $k . ',';
            $pdoArray[':'.$k] = $v;
        }
        $conditions = substr($conditions, 0, -1);

        $connection = \Elision\Orm\Model::getDbConnection();
        $sql = new QueryBuilder();
        $sql->select('*', $table)
            ->where($conditions);

        if ($class == 'Class') {
            $result = $connection->queryClass($sql, static::class, $pdoArray);
            return $result;
        } else {
            $result = $connection->query($sql, $pdoArray);
            return $result;
        }
    }
}