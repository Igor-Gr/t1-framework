<?php

namespace Elision\Validator;


class Validator

{

    public $builtInValidators = [
        'string' => 'Elision\Validator\StringValidator',
        'email' => 'Elision\Validator\EmailValidator'
    ];

    public function createValidator($type, $model, $attributes, $params = [])
    {
        if ($this->hasValidator($type) != false) {
            $validatorPath = $this->hasValidator($type);
            $validator = new $validatorPath;
            return $validator->validate($model, $attributes, $params);
        }
    }

    public function hasValidator($name)
    {
        foreach ($this->builtInValidators as $k => $v) {
            if ($name == $k) {
                return $v;
            }
        }
    }

    public function getValue($model, $attribute)
    {
        foreach ($model as $k => $v) {
            if ($k == $attribute) {
                return $v;
            }
        }
    }
}