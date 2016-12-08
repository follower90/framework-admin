<?php

namespace App\Service;

use Core\Orm;
use Core\Router;

class Meta
{
	public static function getData()
	{
		$url = Router::get('uri');

		$tags = Orm::findOne('Meta', ['url'], [$url]);

		if (!$tags) {
			$tags = Orm::findOne('Meta', ['url'], ['/']);
		}

		return $tags->getValues();
	}
}

