<?php

namespace App\Routes;

class App
{
	public static function register()
	{
		\Core\Router::register(['/404', 'GET'], 'Error', 'index');
		\Core\Router::register(['/*', 'GET'], 'Page', 'index');
	}
}
