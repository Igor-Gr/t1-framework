<?php

namespace Console;

abstract class Command
{
    final public function action($action)
    {
        $methodName = 'action' . $action;
        return $this->$methodName();
    }

    protected function writeLn($msg)
    {
        echo $msg . "\n";
    }
}