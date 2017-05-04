<?php

namespace App\Service;

use Core\Orm;
use Core\Router;

class Meta
{
	private static function _detectModule()
	{
		$uri = Router::get('uri');
		$moduleUri = explode('?', explode('/', $uri)[1])[0];

		return Orm::findOne('Module', ['url'], [$moduleUri]);
	}

	private static function _lastUrlPart()
	{
		$uri = Router::get('uri');
		$parts = explode('/', $uri);
		$lastChunk = $parts[sizeof($parts) - 1];
		return explode('?', $lastChunk)[0];
	}

	public static function getData()
	{
		$uri = Router::get('uri');
		$tags = Orm::findOne('Meta', ['url', 'moduleId'], [$uri, 0]);

		if (!$tags) {
			$module = static::_detectModule();

			if (!$module) $module = Orm::load('Module', 2); //page module HACK
			if ($module) {
				$tags = Orm::findOne('Meta', ['url', 'moduleId'], [static::_lastUrlPart(), $module->getId()]);
			}
		}

		if (!$tags) {
			$tags = Orm::findOne('Meta', ['url'], ['/']);
		}

		return $tags ? $tags->getValues() : [
			'title' => \Admin\Object\Setting::get('sitename'),
			'keywords' => \Admin\Object\Setting::get('sitename'),
			'description' => \Admin\Object\Setting::get('sitename'),
		];
	}
}

