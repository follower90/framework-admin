<?php

namespace Admin\EntryPoint;

use Core\Config;
use Core\App;

class Api extends \Core\EntryPoint
{
	public function init()
	{
		Config::set('site.language', 'ru');
		Config::set('site.url', '/admin');

		\Admin\Routes\Api::register();

		$this->setLib('\Admin\Api');

		$app = new App($this);

		$authorize = new \Core\Authorize('Admin');
		$authorize->getUser();

		$app->run();
	}
}
