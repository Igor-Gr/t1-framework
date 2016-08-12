<?php

namespace Elision\Mvc;

abstract class Controller
{
    
    public $view;
    
    final public function __construct()
    {
        $this->view = new View();
    }
    
    protected function beforeAction()
    {
        
    }
    
    final public function action($action)
    {
        $methodName = 'action' . $action;
        $this->beforeAction();
        return $this->$methodName();
    }
}