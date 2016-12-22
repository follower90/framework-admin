<?php

namespace Admin\Service;

class Meta
{
	public static function getData($url)
	{
		$module = \Admin\Service\Module::detect();
		$tags = \Core\Orm::findOne('Meta', ['url', 'moduleId'], [$url, $module->getId()]);

		return $tags ? $tags->getValues() : [
			'title' => '',
			'keywords' => '',
			'description' => ''
		];
	}
}