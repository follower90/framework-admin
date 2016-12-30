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
		Router::register(['/^\/favourite/', 'GET'], 'Favourite', 'index');
		Router::register(['/^\/contacts$/', 'GET'], 'Contacts', 'index');

		Router::register(['/^\/catalog$/', 'GET'], 'Catalog', 'index', ['url']);
		Router::register(['/^\/blog$/', 'GET'], 'Blog', 'index', ['url']);
		Router::register(['/^\/photos$/', 'GET'], 'Photos', 'index', ['url']);
		Router::register(['/^\/cart$/', 'GET'], 'Cart', 'index', ['url']);
		Router::register(['/^\/order$/', 'GET'], 'Order', 'index', ['url']);
		Router::register(['/^\/user$/', 'GET'], 'User', 'index', ['url']);

		Router::register(['/^\/blog\/view\/(.*)$/', 'GET'], 'Blog', 'index', ['url']);
		Router::register(['/^\/photos\/view\/(.*)$/', 'GET'], 'Photos', 'index', ['url']);
		Router::register(['/^\/catalog\/view\/(.*)$/', 'GET'], 'Catalog', 'index', ['url']);
		Router::register(['/^\/catalog\/search\/?search=(.*)$/', 'GET'], 'Catalog', 'search', ['search']);
		Router::register(['/^\/product\/view\/(.*)$/', 'GET'], 'Product', 'index', ['url']);

		Router::register(['/^\/(\w+\d*)$/', 'GET'], 'Page', 'index', ['page']);
	}
}
