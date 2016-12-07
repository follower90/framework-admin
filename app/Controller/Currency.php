<?php

namespace App\Controller;

use Core\Cookie;
use Core\Router;

class Currency extends Controller
{
	public function methodIndex($args)
	{
		Cookie::set('site_currency', $args['switch']);
		Router::redirect(Router::get('referer'));
	}
}

