<?php

namespace Admin\Routes;

class Admin
{
	public static function register()
	{
		// No custom routes added yet.
		// To add them use Router::register or new Router()->route 	method

		// Aliases
		\Core\Router::alias('pages', 'Page');
	}
}