<?php

namespace Admin\EntryPoint;

use Core\Config;
use Core\App;

class Base extends \Core\EntryPoint
{
	public function init()
	{
		Config::set('site.language', 'ru');
		Config::set('site.url', '/admin');

		\Admin\Routes\Routes::register();

		$this->setLib('\Admin\Controller');

		$app = new App($this);

		$authorize = new \Core\Authorize('Admin');
		$authorize->getUser();

		$app->run();
	}
}
