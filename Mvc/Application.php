<?php

namespace Orm;

use Core\ISingleton;
use Core\TSingleton;

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