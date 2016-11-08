<?php

namespace App\Routes;

use Core\Router;

class App
{
	public static function register()
	{
		Router::alias('pages', 'Page');
		Router::actionAlias('all', 'index');

		Router::register(['/^\/404$/', 'GET'], 'Error', 'index');
		Router::register(['/^\/(\w+\d*)$/', 'GET'], 'Page', 'index', ['page']);
		Router::register(['/^\/catalog\/(.*)$/', 'GET'], 'Catalog', 'index', ['url']);
		Router::register(['/^\/product\/(.*)$/', 'GET'], 'Product', 'index', ['url']);
	}
}
