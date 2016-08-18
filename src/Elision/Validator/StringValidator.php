<?php


namespace Elision\Validator;


class StringValidator
    extends Validator
{


    public $message = [];

    public $valid = true;

    public function validate($model, $attributes, $params = [])
    {

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
                               $this->message[] = $params['message'];
                           else $this->message[] = 'min_error';
                           $this->valid = false;

                       }
                        break;
                    case 'max':
                        if ($v < mb_strlen($value)) {

                            if (!empty($params['message']))
                                $this->message[] = $params['message'];
                            else $this->message[] = 'max_error';
                            $this->valid =  false;

                        }
                    break;
                }
            }
        }

        return [
            $this->valid,
            $this->message
        ];
    }

}