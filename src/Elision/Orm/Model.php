<?php

namespace Elision\Orm;


use Elision\Validator\Validator;

class Model
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
            static::$connection = new \Elision\Db\Connection(new \Elision\Core\Config('protect/config.php'));
        }
        return static::$connection;
    }

    public function validate()
    {
        $val = $this->createValidators();

        var_dump($val);
        
    }

    /**
     * Массив установок для валидации полей форм
     *
     * @return array
     */
    public function setting()
    {
        return [];
    }

    public function createValidators()
    {
        $objetArray = [];
        foreach ($this->setting() as $setting) {
            if ($setting instanceof Validator) {
                // Включаем валидатор
            } elseif (is_array($setting) && isset($setting[0], $setting[1])) {
                $validator = new Validator();
                $objetArray[] = $validator->createValidator($setting[1], $this, (array) $setting[0], array_slice($setting, 2));
            }
        }
        return $objetArray;
    }
}