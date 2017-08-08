<?php

namespace Admin\Service;

use Core\Orm;

class Meta
{
	public static function getData($url)
	{
		$module = \Admin\Service\Module::detect();
		$tags = Orm::findOne('Meta', ['url', 'moduleId'], [$url, $module->getId()]);

		return $tags ? $tags->getValues() : [
			'title' => '',
			'keywords' => '',
			'description' => ''
		];
	}

	public static function update($data)
	{
		$meta = Orm::findOne('Meta', ['url', 'moduleId'], [$data['url'], $data['moduleId']]);

		if (!$data['title'] && !$data['keywords'] && !$data['description']) {
			if ($meta) {
				Orm::delete($meta);
			}
			return;
		}

		if (!$meta) {
			$meta = Orm::create('Meta');
		}

		$meta->setValues([
			'moduleId' => $data['moduleId'],
			'url' => $data['url'],
			'title' => $data['title'],
			'keywords' => $data['keywords'],
			'description' => $data['description'],
		]);

		$meta->save();
	}


	public static function editor($url)
	{
		$view = new \Core\View();
		$view->setDefaultPath('public/admin');

		$module = \Admin\Service\Module::detect();

		return $view->render('templates/common/meta.phtml', [
			'moduleId' => $module->getId(),
			'module' => $module->getValue('url'),
			'url' => $url,
			'meta' => static::getData($url)
		]);
	}
}