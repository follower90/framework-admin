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

		\Admin\Routes\Admin::register();

		$this->setLib('\Admin\Controller');

		$app = new App($this);
		$app->setVendorPath('/vendor/follower/admin');

		$authorize = new \Core\Authorize('Admin');
		Config::set('user', $authorize->getUser());

		$app->run();
	}
}
