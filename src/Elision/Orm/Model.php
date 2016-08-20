<?php

namespace Elision\Orm;


use Elision\Messages\Errors;
use Elision\Messages\Message;
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
        $result = [];

        for ($i = 0; $i < count($val); $i++) {
            if ($val[$i][0] == false && !is_null($val[$i][0])) {
                $result[] = 'Err';
                $message = $val[$i][1][0];
                $value = $val[$i][2];
                $fieldName = $val[$i][3];
                Errors::$errors[] = Message::parseMessages($message, $value, $fieldName);
            }
        }

        if (empty($result)) {
            return true;
        } else {
            return false;
        }

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