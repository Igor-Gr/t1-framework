<?php


namespace Elision\Validator;


class RequiredValidator
    extends Validator
{


    public function validate($model, $attributes, $params = [])
    {
        if (isset($attributes[0]) && !isset($attributes[1])) {
            $value = $this->getValue($model, $attributes[0]);

        } else {
            // esli polei neskolko
        }

        echo $value;
    }
}