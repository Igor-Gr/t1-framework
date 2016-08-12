<?php

namespace Elision\Console;

abstract class Command
{
    final public function action($action, $params = [])
    {
        $methodName = 'action' . $action;
        $options = $params;
        return $this->$methodName($options[0], $options[1]);
    }

    protected function writeLn($msg)
    {
        echo $msg . "\n";
    }
}