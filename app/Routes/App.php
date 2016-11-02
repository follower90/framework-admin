<?php

namespace App\Routes;

class App
{
	public static function register()
	{
		\Core\Router::register(['/', 'GET'], 'Index', 'index');
		\Core\Router::register(['/404', 'GET'], 'Error', 'index');
		\Core\Router::register(['/catalog/:url', 'GET'], 'Catalog', 'index');

		\Core\Router::register(['/:page', 'GET'], 'Page', 'index');
	}
}
