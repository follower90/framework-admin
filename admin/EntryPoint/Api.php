<?php

namespace Admin\EntryPoint;

use Core\Config;
use Core\App;

class Api extends \Core\EntryPoint
{
	public function init()
	{
		Config::set('site.url', 'admin');

		\Admin\Utils::setLanguage();
		\Admin\Routes\Api::register();

		$this->setLib('\Admin\Api');

		$app = new App($this);

		$authorize = new \Admin\Authorize('Admin');
		$authorize->getUser();

		$app->run();
	}

	public function debug()
	{
		if ($this->request('debug') == 'on') {
			return true;
		}

		return false;
	}

	public function output($data)
	{
		header('Content-Type: application/json');

		if ($this->debug()) {
			header('Content-Type: text/html');
		}

		return json_encode($data);
	}
}
