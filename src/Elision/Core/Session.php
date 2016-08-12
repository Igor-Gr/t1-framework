<?php

namespace Elision\Core;

class Session
{

	private static $_is_started = false;
	
	public static function init ()
	{
		if (self::$_is_started == false) {
			session_start();
			self::$_is_started = true;
		}
	}

	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public static function get($key)
	{
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		} else {
			return null;
		}
	}

	public static function clear($key)
	{
		unset($_SESSION[$key]);
	}

	public static function unseted()
	{
		if (self::$_is_started == true) {
			session_unset();
		}
	}

	public static function destroy()
	{
		if (self::$_is_started == true) {
			session_unset();
			session_destroy();
		}
	}
}