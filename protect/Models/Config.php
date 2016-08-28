<?php

namespace protect\Models;


use Elision\Orm\ActiveRecord;

class Config
    extends ActiveRecord
{

    public $client_id;
    public $title;
    public $description;
    public $image;
}