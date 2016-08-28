<?php

namespace protect\Models;


use Elision\Orm\ActiveRecord;

class Balance
    extends ActiveRecord
{

    public $client_id;
    public $balance;
}