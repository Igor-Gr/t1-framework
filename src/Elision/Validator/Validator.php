<?php

namespace Elision\Validator;


class Validator

{

    public $builtInValidators = [
        'string' => 'Elision\Validator\StringValidator',
        'email' => 'Elision\Validator\EmailValidator',
        'required' => 'Elision\Validator\RequiredValidator',
        'coincidence' => 'Elision\Validator\CoincidenceValidator',
        'unique' => 'Elision\Validator\UniqueValidator'
    ];

    public function createValidator($type, $model, $attributes, $params = [])
    {
        if ($this->hasValidator($type) != false) {
            $validatorPath = $this->hasValidator($type);
            $validator = new $validatorPath;
            return $validator->validate($model, $attributes, $params);
        } else {
            return $model->$type();
        }
    }

    public function hasValidator($name)
    {
        foreach ($this->builtInValidators as $k => $v) {
            if ($name == $k) {
                return $v;
            }
        }
        return false;
    }

    public function getValue($model, $attribute)
    {
        foreach ($model as $k => $v) {
            if ($k == $attribute) {
                return $v;
            }
        }
    }

    public function parseFieldName($filed, $params)
    {
        foreach ($params as $k => $v) {
            if ($k == $filed) {
                return $v;
            }
        }
        return false;
    }
}