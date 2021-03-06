<?php

namespace Elision\Console;

use Elision\Core\ISingleton;
use Elision\Core\TSingleton;

class Application
    implements
        ISingleton
{
    
    use TSingleton;
    
    public $commandName;
    public $actionName;
    
    const ERROR_CODE = 1;
    const COMMANDS_PATH = 'Elision\\Commands\\';
    
    public function run ()
    {
        try {
            $this->runRequest();
        } catch (Exception $e) {
            $this->halt('ERROR: ' . $e->getMessage());
        }
    }
    
    public function runRequest () {
        $arguments = array_slice($_SERVER['argv'], 1);
        $str = '';
        foreach ($arguments as $v) {
            $str .= $v;
        }
        
        $arguments = explode('/', trim($str,'/'));
        if (!empty($arguments[0])) {
            $this->commandName = ucfirst($arguments[0]);
        } else {
            $this->commandName = 'Application';
        }
         if (!empty($arguments[1])) {
            $this->actionName = $arguments[1];
        } else {
             $this->actionName = 'Default';
         }
        if (!empty($arguments[2])) {
            $options = [];
            for ($i = 2; $i < count($arguments); $i++) {
                $options[] = $arguments[$i];
            }
        }
        $commandClass = self::COMMANDS_PATH . $this->commandName;
        $command = new $commandClass();
        $command->action($this->actionName, $options);
    }
    
    
    public function halt($message = '')
    {
        if (!empty($message)) {
            echo $message . "\n";
        }
        exit(self::ERROR_CODE);
    }
}