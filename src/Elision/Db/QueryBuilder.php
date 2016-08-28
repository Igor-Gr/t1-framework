<?php

namespace Elision\Db;

use Elision\Orm\Model;

class QueryBuilder
{
    /**
     * Запрос формируется начиная с метода find(), далее идут опции.
     * Пример:
     * $user->find()->asArray()->where(['id' => '25'])->all()
     * Достаёт из таблици User в виде массива все данные где id равен 25
     * 
     * Возможные команды:
     * find() - создает обьект query builder
     * asArray() - возвращает данные в виде ассоциативного массива
     * where() - условия, принимает ассоциативный массив
     * all() - инициализирует зпрос
     * findBySql() - поиск по своему запросу
     * findOne() - то же самое что и where(), только возвращает первый найденый элемент (не требует ->all() в конце)
     */

    /**
     * Строка составляющая sql запрос
     *
     * @var string
     */
    public $data;

    /**
     * Имя таблицы (имя класса по умолчанию)
     *
     * @var null
     */
    public $table;

    /**
     * @var \PDO
     */
    public $connection;

    /**
     * Класс модели от которой идёт запрос
     *
     * @var null
     */
    public $model;

    /**
     * Массив подстановок в PDO
     *
     * @var
     */
    public $pdo;

    /**
     * Тригер возврата данных в виде массива
     *
     * @var bool
     */
    public $asArray = false;

    /**
     * Тригер своего sql запроса
     *
     * @var bool
     */
    public $sql = false;


    public function __construct($table = null, $connection = null, $model = null)
    {
        $this->table = $table;
        $this->connection = $connection;
        $this->model = $model;

        foreach ($this as $v) {
            if ($v == $table || $v == $connection || $v == $model || $v == $this->pdo) continue;
            $this->data .= $v;
        }

    }

    public function __toString()
    {
        return $this->data;
    }

    public static function find()
    {
        return new QueryBuilder(static::getClassName(), Model::getDbConnection(), static::class);
    }

    public static function findOne($options)
    {
        $qb = new QueryBuilder(static::getClassName(), Model::getDbConnection(), static::class);

        $query = $qb->parseQuery($options);

        $qb->data .= 'SELECT * FROM ' . $qb->table . ' WHERE ' . $query['fields'];
        $qb->pdo = $query['pdo'];

        $driver = $qb->connection->getDriver();

        $result =  $driver->all($qb->connection, $qb->data, $qb->model, $qb->asArray, $qb->pdo);

        $qb->deleteWorkingPropertys($result);

        if (is_array($result)) return $result[0];
        return $result;

    }

    public function findBySql($sql)
    {
        $qb = new QueryBuilder($this->getClassName(), Model::getDbConnection(), static::class);
        return $qb->sqlQuery($sql);
    }

    public function all()
    {
        if ($this->sql !== true) {
            if (empty($this->data)) {
                $this->data = 'SELECT * FROM ' . $this->table;
            } else {
                $this->data = 'SELECT * FROM ' . $this->table . $this->data;
            }
        }

        $driver = $this->connection->getDriver();

        $result =  $driver->all($this->connection, $this->data, $this->model, $this->asArray, $this->pdo);

        $this->deleteWorkingPropertys($result);
        
        return $result;
    }

    /**
     * Удаляет рабочие свойства обьекта, при обработке результата запроса
     * 
     * @param $class
     */
    public function deleteWorkingPropertys($class)
    {
        if (is_array($class)) {
            foreach ($class as $k => &$v) {
                unset($v->data);
                unset($v->table);
                unset($v->connection);
                unset($v->model);
                unset($v->pdo);
                unset($v->asArray);
                unset($v->sql);
            }
        } else {
            unset($class->data);
            unset($class->table);
            unset($class->connection);
            unset($class->model);
            unset($class->pdo);
            unset($class->asArray);
            unset($class->sql);
        }
    }

    public function select($what = '*', $table = null)
    {
        if ($what == '*') {
            $this->data .= 'SELECT * FROM ' . $table;
        }
        return $this;
    }

    public function table($table)
    {
        $this->data .= $table . ' ';
        return $this;
    }

    public function insert($table = null)
    {
        $this->data .= 'INSERT INTO ' . $table . ' ';
        return $this;
    }

    public function values($what)
    {
        $this->data .= $what;
        return $this;
    }

    public function asArray()
    {
        $this->asArray = true;
        return $this;
    }

    /**
     * Принимает массив SQL запроса и парсит его в PDO формат,
     * вида имя=:имя ...
     * и PDO массив расшифровку вида [':имя' => значение]
     *
     * Возвращает ассоциативный массив с двумя значениями,
     * именами запроса и PDO массив расшифровку
     *
     * @param $options
     * @return array
     */
    public function parseQuery($options)
    {
        $fieldNames = '';
        $pdoArray = [];

        foreach ($options as $field => $value) {
            $fieldNames .= $field . '=:' . $field . ',';
            $pdoArray[':'.$field] = $value;
        }
        
        $fieldNames = substr($fieldNames, 0, -1);
        
        return [
            'fields' => $fieldNames,
            'pdo' => $pdoArray
        ];
    }

    public function where($options)
    {

        $fields = $this->parseQuery($options);

        $this->data .= ' WHERE ' . $fields['fields'];
        $this->pdo = $fields['pdo'];

        return $this;
    }

    public function sqlQuery($sql)
    {
        $this->sql = true;
        $this->data .= $sql;
        return $this;
    }

}