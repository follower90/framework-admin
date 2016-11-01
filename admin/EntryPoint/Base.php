<?php

namespace Admin\EntryPoint;

use Core\Config;
use Core\App;

class Base extends \Core\EntryPoint
{
	public function init()
	{
		Config::set('site.url', 'admin');

		\Admin\Utils::setLanguage();
		\Admin\Routes\Admin::register();

		$this->setLib('\Admin\Controller');

		$app = new App($this);
		$app->setVendorPath('admin');

		$authorize = new \Core\Authorize('Admin');
		Config::set('user', $authorize->getUser());

		$app->run();
	}
}
