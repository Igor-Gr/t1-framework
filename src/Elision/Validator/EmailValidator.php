<?php

namespace Elision\Validator;

use Elision\Messages\Errors;
use Elision\Messages\Message;

class EmailValidator
    extends Validator
{

    public $patern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';

    public $message;
    public $value;
    public $valid = true;
    public $field;

    public function validate($model, $attributes, $params = [])
    {
        $value = $this->getValue($model, $attributes[0]);

        $result = preg_match($this->patern, $value);

        if (!$result) {
            $this->message = 'wrong_email';
            $this->valid = false;
            $this->field = 'E-mail';
            Errors::$errors[] = Message::parseMessages($this->message, [], $this->field);
        }

        return $this->valid;
    }
}