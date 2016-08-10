<?php

namespace Mvc;

use Core\ISingleton;
use Core\TSingleton;

class Router
	implements 
		ISingleton,
		IRouter
{
	use TSingleton;
            
    public $controller;
    public $action;
    
    const DEFAULT_CONTROLLER = 'Index';
    const DEFAULT_ACTION = 'Default';
    const CONTROLLER_PATH = 'protect\Controllers\\';
            
    protected function __construct () {
		$request = $_SERVER['REQUEST_URI'];
		$splits = explode('/', trim($request,'/'));

		if (!empty($splits[0])) {
			$this->controller = $splits[0];
		} else {
			$this->controller = self::DEFAULT_CONTROLLER;
		}

		if (!empty($splits[1])) {
			$this->action = $splits[1];
		} else {
			$this->action = self::DEFAULT_ACTION;
		}
		
	}
			
	public function route()
	{
		$controller_init = self::CONTROLLER_PATH . $this->controller;
        
        if (class_exists($controller_init)) {
            $controller = new $controller_init();
            if (method_exists($controller, 'action' . $this->action)) {
                $controller->action($this->action);
            } else {
                
            }
        } else {
            
        }
	}
}