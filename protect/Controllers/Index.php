<?php

namespace protect\Controllers;

use Elision\Http\Request;
use Elision\Mvc\Controller;
use protect\Models\Signup;

class Index
    extends Controller
{
	
	public function actionDefault()
	{
		$this->view->display('Index.php');
	}

	public function actionSignup()
	{
		$model = new Signup();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			Request::setFormValuesInClassAttributes($model);

			$model->validate();
		}

		$this->view->display('signup.php');
	}
	
}