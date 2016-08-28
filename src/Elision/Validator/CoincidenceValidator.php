<?php

namespace Elision\Validator;

use Elision\Messages\Errors;
use Elision\Messages\Message;

class CoincidenceValidator
    extends Validator
{


    public $message;
    public $field;
    public $valid = true;
    public $value;

    public function validate($model, $attributes, $params = [])
    {
        $values = [];

        if (isset($params['fields'])) {
            $this->field = $params['fields'];
        }

        foreach ($attributes as $v) {
            $values[] = $this->getValue($model, $v);
        }

        $val = array_unique($values);

        if (count($val) !== 1) {
            $this->message = 'do_not_match';
            $this->valid = false;
            Errors::$errors[] = Message::parseMessages($this->message, [], $this->field);
        }

        return $this->valid;
    }
}