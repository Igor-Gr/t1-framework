<?php


namespace Elision\Validator;

use Elision\Messages\Errors;
use Elision\Messages\Message;

class StringValidator
    extends Validator
{


    public $message;
    public $value;
    public $valid = true;
    public $field;

    /**
     * Возвращает  массив с четырьмя значениями:
     * булево true or false, проша валидация или нет,
     * шаблон сообщения для дальнейшей обратоки,
     * значение которое не прошло валидацию, для дальнейшей подстановки в шаблон сообщения,
     * и имя поля так же для подстановки в шаблон.
     *
     * @param $model
     * @param $attributes
     * @param array $params
     * @return array
     */
    public function validate($model, $attributes, $params = [])
    {

        $attributeName = '';

        for ($i = 0; $i < count($attributes); $i++) {
            $attributeName = $attributes[$i];
        }

        $this->field = $this->parseFieldName($attributeName, $params) ?: $attributes[0];

        if (isset($attributes[0]) && !isset($attributes[1])) {
            $value = $this->getValue($model, $attributes[0]);

        } else {
            // esli polei neskolko
        }

        foreach ($params as $k => $v) {
            if (isset($params)) {
                switch ($k) {
                    case 'min':
                       if ($v > mb_strlen($value)) {

                           if (!empty($params['message']))
                               $this->message = $params['message'];
                           else $this->message = 'min_error';
                           $this->valid = false;
                           $this->value = $v;
                           Errors::$errors[] = Message::parseMessages($this->message, $this->value, $this->field);
                       }
                        break;
                    case 'max':
                        if ($v < mb_strlen($value)) {

                            if (!empty($params['message']))
                                $this->message = $params['message'];
                            else $this->message = 'max_error';
                            $this->valid =  false;
                            $this->value = $v;
                            Errors::$errors[] = Message::parseMessages($this->message, $this->value, $this->field);
                        }
                    break;
                }
            }
        }

        return $this->valid;
    }

}