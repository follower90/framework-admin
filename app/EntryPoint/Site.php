<?php

namespace App\EntryPoint;

use Core\Config;
use Core\App;

class Site extends \Core\EntryPoint
{
	public function init()
	{
		\Admin\Utils::setLanguage();
		\Admin\Utils::setCurrency();

		\App\Routes\App::register();

		$this->setLib('\App\Controller');

		$app = new App($this);
		$app->setVendorPath('app');

		$authorize = new \Admin\Authorize('User');
		Config::set('user', $authorize->getUser());

		$app->run();
	}
}
