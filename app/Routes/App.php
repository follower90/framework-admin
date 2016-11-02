<?php

namespace App\Routes;

use Core\Router;

class App
{
	public static function register()
	{
		Router::register(['/', 'GET'], 'Index', 'index');

		Router::register(['/catalog/:url', 'GET'], 'Catalog', 'index');
		Router::register(['/catalog/*', 'GET'], 'Catalog', 'index');

		Router::register(['/404', 'GET'], 'Error', 'index');
		Router::register(['/:page', 'GET'], 'Page', 'index');
	}
}
