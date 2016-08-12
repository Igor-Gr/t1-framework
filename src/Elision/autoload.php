<?php

function __autoload($className)
{
	if ('Elision' == substr($className, 0, 7)) {
		$fileName = 'src//' . $className . '.php';
	} else {
		require $className . '.php';
	}

	if (is_readable($fileName)) {
		require $fileName;
		return true;
	} else {
		return false;
	}
}