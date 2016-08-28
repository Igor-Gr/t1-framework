<?php

namespace protect\Controllers;

use Elision\Auth\Identity;
use Elision\Core\Session;
use Elision\Http\Request;
use Elision\Messages\Errors;
use Elision\Mvc\Controller;
use protect\Models\Lc;
use protect\Models\Login;
use protect\Models\Signup;

class Index
    extends Controller
{
	
	public function actionDefault()
	{
		Session::init();

		$this->view->display('index.php', ['title' => 'Главная']);
	}

	public function actionSignup()
	{
		Session::init();

		$model = new Signup();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			Request::setFormValuesInClassAttributes($model);

			if ($model->validate() && $model->signup()) {
				$this->goHome();
			}
			$error = Errors::showErrors();
		}

		$this->view->display('signup.php', ['title' => 'Регестрация', 'error' => $error]);
	}

	public function actionLogin()
	{
		Session::init();

		$login_model = new Login();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			Request::setFormValuesInClassAttributes($login_model);

			if ($login_model->validate()) {
				Identity::login($login_model->getUser());
				$this->goHome();
			}

			$error = Errors::showErrors();
		}

		$this->view->display('login.php', ['error' => $error]);
	}
	
	public function actionOut()
	{
		Session::init();
		Session::unseted();

		$this->view->display('Index.php', ['title' => 'Главная']);
	}
	
	public function actionLc()
	{
		Session::init();

		$lc_model = new Lc();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			Request::setFormValuesInClassAttributes($lc_model);

			$lc_model->validate();

			$lc_model->setConfig($_SESSION['client_id']);

			$error = Errors::showErrors();
		}

		$this->view->display('lc.php', ['title' => 'Главная', 'error' => $error]);
	}

	public function actionBoot()
	{
		$this->view->display('bootstrap.php', ['title' => 'Главная']);
	}
	
}