<?php

namespace Admin\Controller;

use Core\Cookie;
use Core\Router;

class Lang extends Controller
{
	public function methodIndex($args)
	{
		Cookie::set('site_language', $args['switch']);
		$this->back();
	}
}
