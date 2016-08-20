<?php

namespace protect\Controllers;

use Elision\Http\Request;
use Elision\Messages\Errors;
use Elision\Messages\Message;
use Elision\Mvc\Controller;
use protect\Models\Signup;

class Index
    extends Controller
{
	
	public function actionDefault()
	{
		$this->view->display('Index.php', ['title' => 'Главная']);
	}

	public function actionSignup()
	{
		$model = new Signup();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			Request::setFormValuesInClassAttributes($model);

			$model->validate();
			$error = Errors::showErrors();
		}

		$this->view->display('signup.php', ['title' => 'Регестрация', 'error' => $error]);
	}

	public function actionBoot()
	{
		$this->view->display('bootstrap.php', ['title' => 'Главная']);
	}
	
}