<?php

namespace protect\Controllers;

use Core\Session;
use Orm\Controller;

class Index
    extends Controller
{
	
	public function actionDefault ()
	{
		$this->view->display('Index.php');
	}
	
}