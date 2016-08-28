<?php

namespace Elision\Core;


class Std
{

    public function __construct($data = null)
    {
        if ($data !== null) {
            $this->fromArray($data);
        }
    }

    public function fromArray($data)
    {
        $data = (array)$data;
        foreach ($data as $key => $value) {
            $this->innerSet($key, $value);
        }
        return $this;
    }

    protected function innerSet($key, $val)
    {
        if (is_array($val)) {
            foreach ($val as $k => $v) {
                $this->$k = $v;
            }
        }

        if (!is_array($val))
       $this->$key = $val;
    }
}