<?php

namespace Elision\Orm;

use Elision\Db\Connection;
use Elision\Core\Config;
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
            static::$connection = new Connection(Config::getConfig());
        }
        return static::$connection;
    }

    /**
     * Валидация значений форм, конечный этап валидации,
     * ловит результат пришедший с валидатора в виде массива из 4 значений,
     * булево (прошла или нет валидация), короткое сообщение, и значение с именем поля,
     * которые не проши валидацию, для дальнейшей подстановки в главный шаблон сообщения.
     *
     * Вернёт true or false в зависимости от того пройдена валидация или нет.
     *
     * @return bool
     */
    public function validate()
    {
        $val = $this->createValidators();

        foreach ($val as $v) {
            if ($v === false) {
                return false;
            }
        }
        return true;
    }


    /**
     * Массив установок для валидации полей форм.
     * 
     * Принимает массив массивов, первый параметр имя поля формы,
     * (если хотим применить настройки для нескольких полей то первый параметром
     * ставим массив из нужных полей) вторым параметром идет имя валидатора, третим
     * ассициативные данные ктороре являются опциями выбраного валидатора.
     * Проимер: [
     *      ['password', 'string', 'min' => 6, 'max' => 10, 'field' => 'Пароль']
     * ]
     *
     * @return array
     */
    public function setting()
    {
        return [];
    }

    public function createValidators()
    {
        $objectArray = [];
        
        foreach ($this->setting() as $setting) {
            if ($setting instanceof Validator) {
                // Включаем валидатор
            } elseif (is_array($setting) && isset($setting[0], $setting[1])) {
                $validator = new Validator();
                $objectArray[] = $validator->createValidator($setting[1], $this, (array) $setting[0], array_slice($setting, 2));
            }
        }
        return $objectArray;
    }

}