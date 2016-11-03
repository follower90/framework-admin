<?php

namespace App\Routes;

use Core\Router;

class App
{
	public static function register()
	{
		Router::register(['/', 'GET'], 'Index', 'index');
		Router::register(['/404', 'GET'], 'Error', 'index');
		Router::register(['/:page', 'GET'], 'Page', 'index');

		//Will dynamically match any Controller->methodIndex
		Router::register(['/*/:url', 'GET'], '*', 'index');

		//Will dynamically match any Controller->Any Method
		Router::register(['/*/*/:url', 'GET'], '*', '*');
		Router::register(['/*/*', 'GET'], '*', '*');
	}
}
