<?php

function __autoload($className)
{
	if ('Elision' == substr($className, 0, 7)) {
		$fileName = __DIR__ . '/' . 'src//' . str_replace('\\', '/', $className) . '.php';
	} else {
		require __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
	}

	if (is_readable($fileName)) {
		require $fileName;
		return true;
	} else {
		return false;
	}
}