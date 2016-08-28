<?php

namespace protect\Models;


use Elision\Auth\IdentityInterface;
use Elision\Orm\ActiveRecord;

class Users
    extends ActiveRecord
        implements IdentityInterface
{

    public function setPassword($password)
    {
        $this->password = sha1($password);
    }
    
}