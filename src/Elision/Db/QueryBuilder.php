<?php

namespace Elision\Db;


class QueryBuilder
{

    public $data;

    public function __construct()
    {
        foreach ($this as $v) {
            $this->data .= $v;
        }
    }

    public function __toString()
    {
        return $this->data;
    }

    public function select($what = '*', $table = null)
    {
        if ($what == '*') {
            $this->data .= 'SELECT * FROM ' . $table;
        }
        return $this;
    }

    public function table($table)
    {
        $this->data .= $table . ' ';
        return $this;
    }

    public function insert($table = null)
    {
        $this->data .= 'INSERT INTO ' . $table . ' ';
        return $this;
    }

    public function values($what)
    {
        $this->data .= $what;
        return $this;
    }

    public function where($options)
    {
        $this->data .= ' WHERE ' .$options;
        return $this;
    }
}