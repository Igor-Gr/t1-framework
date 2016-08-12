<?php

namespace protect\Controllers;

use Elision\Core\Session;
use Elision\Mvc\Controller;

class Index
    extends Controller
{
	
	public function actionDefault ()
	{
		$this->view->display('Index.php');
	}
	
}