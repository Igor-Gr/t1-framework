<?php

namespace Core;

class Config
    extends Std
{
    /**
     * @param array|string|null $data
     * @throws \Core\Exception
     * @property $path string
     */
    public function __construct($data = null)
    {
        if ($data !== null) {
            if (is_array($data)) {
                parent::__construct($data);
            } else {
                $this->load((string)$data);
            }
        }
    }

    /**
     * @param string $path
     * @return \Core\Config
     * @throws \Core\Exception
     */
    public function load($path)
    {
        if (!is_readable($path)) {
            throw new Exception('Config file ' . $path . ' is not found or is not readable');
        }

        return $this->fromArray(include($path));
    }
}