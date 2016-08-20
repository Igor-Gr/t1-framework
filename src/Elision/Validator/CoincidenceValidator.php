<?php

namespace Elision\Validator;


class CoincidenceValidator
    extends Validator
{


    public $message = [];
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
            $this->message[] = 'do_not_match';
            $this->valid = false;
        }

        return [
            $this->valid,
            $this->message,
            $this->value,
            $this->field
        ];
    }
}