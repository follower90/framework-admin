<?php

namespace Admin\Routes;

class Admin
{
	public static function register()
	{
		\Core\Router::alias('pages', 'Page');
		\Core\Router::register(['/^\/404$/', 'GET'], 'Error', 'index');
	}
}
