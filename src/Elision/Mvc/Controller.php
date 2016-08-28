<?php

namespace Elision\Mvc;

use Elision\Http\Request;
use Elision\Http\Response;

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

    public function goHome()
    {
        Response::redirect(Request::getHomeUrl());
    }

    public function getMemory()
    {
        return memory_get_usage() . ' байт';
    }
}