<?php

namespace protect\Controllers;

use Core\Session;
use Mvc\Controller;

class Index
    extends Controller
{
	
	public function actionDefault ()
	{
		$this->view->display('Index.php');
	}
	
}