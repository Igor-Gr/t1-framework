<?php

function __autoload ($class) {
	$filename = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
	if (file_exists($filename)) {
		include $filename;
	}
}