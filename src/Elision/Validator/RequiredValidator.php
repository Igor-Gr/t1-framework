<?php


namespace Elision\Validator;


use Elision\Messages\Errors;
use Elision\Messages\Message;

class RequiredValidator
    extends Validator
{


    public $message;
    public $field;
    public $valid = true;
    public $value;

    public function validate($model, $attributes, $params = [])
    {
        $attributeValues = [];
        if (isset($attributes[0]) && !isset($attributes[1])) {
            $value = $this->getValue($model, $attributes[0]);

        } else {
            for ($i = 0; $i < count($attributes); $i++) {
                $attributeValues[$attributes[$i]] = $this->getValue($model, $attributes[$i]);
            }
        }

        foreach ($attributeValues as $k => $v) {
            if (empty($v)) {
                $this->message = 'empty_value';
                $this->valid = false;
                if (!empty($params)) $this->field = $this->parseFieldName($k, $params);
                else $this->field = $k;
                Errors::$errors[] = Message::parseMessages($this->message, [], $this->field);

                return $this->valid;
            }
        }

    }

}