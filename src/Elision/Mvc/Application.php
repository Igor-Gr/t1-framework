<?php

namespace Elision\Mvc;

use Elision\Core\ISingleton;
use Elision\Core\TSingleton;

class Application
	implements
		ISingleton,
		IApplication
{
	use TSingleton;
	
	public function run()
	{
		$route = Router::instance()->route();
	}
	
}