<?php

namespace Elision\Validator;

use Elision\Messages\Errors;
use Elision\Orm\Model;
use Elision\Messages\Message;

class UniqueValidator
    extends Validator
{

    public $message;
    public $value;
    public $valid = true;
    public $field;

    public function validate($model, $attributes, $params = [])
    {
        $tableName = $params['table'];

        foreach ($attributes as $attribute) {
            $value = $this->getValue($model, $attribute);
            $connection = Model::getDbConnection();
            $sql =  'SELECT * FROM ' . $tableName . ' WHERE ' . $attribute . '=' . "'$value'";
            $result = $connection->query($sql);
            if (!empty($result)) {
                $this->message = 'not_unique';
                $this->valid = false;
                $this->field = $this->parseFieldName($attribute, $params);
                Errors::$errors[] = Message::parseMessages($this->message, [], $this->field);

                return $this->valid;
            }
        }
    }
}