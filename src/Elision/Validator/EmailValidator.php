<?php


namespace Elision\Validator;


class EmailValidator
    extends Validator
{

    public $patern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';

    public $message = [];
    public $value;
    public $valid = true;
    public $field;

    public function validate($model, $attributes, $params = [])
    {
        $value = $this->getValue($model, $attributes[0]);

        $result = preg_match($this->patern, $value);

        if (!$result) {
            $this->message[] = 'wrong_email';
            $this->valid = false;
            $this->field = 'E-mail';
        }

        return [
            $this->valid,
            $this->message,
            $this->value,
            $this->field
        ];
    }
}