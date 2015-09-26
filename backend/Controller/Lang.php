<?php

namespace Admin\Controller;

use \Core\Router;
use \Core\Config;

class Lang extends Controller
{
	public function methodIndex($args)
	{
		var_dump($args);
		Config::set('site.language', 'ru');
		Router::redirect(Router::get('referer'));
	}
}
