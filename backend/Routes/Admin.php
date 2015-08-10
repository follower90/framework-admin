<?php

namespace Admin\Routes;

class Admin
{
	public static function register()
	{
		// No custom routes added yet.
		// To add them use Router::register method

		// Aliases
		\Core\Router::alias('pages', 'Page');
		//\Core\Router::alias('page', 'Error');
	}
}
