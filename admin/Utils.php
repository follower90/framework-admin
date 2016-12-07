<?php

namespace Admin;

use Core\Config;
use Core\Cookie;
use Core\Library\File;
use Core\Orm;

class Utils
{
	public static function translate($key, $type = 'admin')
	{
		if ($translation = static::loadFromCache($key, $type)) {
			return $translation;
		}

		if ($data = Orm::findOne('Translation', ['alias', 'type'], [$key, $type])) {
			return $data->getValue('value') ? $data->getValue('value') : $key;
		}

		$translate = Orm::create('Translation');
		$translate->setValue('alias', $key);
		$translate->setValue('type', $type);
		Orm::save($translate);

		return $key;
	}

	public static function setLanguage()
	{
		if ($lang = Cookie::get('site_language')) {
			Config::set('site.language', $lang);
		} else {
			Config::set('site.language', 'ru');
		}
	}

	public static function setCurrency($name)
	{
		if ($id = Cookie::get('site_currency')) {
			Config::set('site.currency', $id);
		} else {
			Config::set('site.currency', Orm::findOne('Currency', ['lang.name'], [$name])->getId());
		}
	}

	private static function loadFromCache($key, $type)
	{
		$translation = File::get('/translations_cache.json');
		$data = json_decode($translation, true);
		$lang = Config::get('site.language');

		if (isset($data[$lang])
			&& isset($data[$lang][$type])
			&& isset($data[$lang][$type][$key])) {

				return $data[$lang][$type][$key];
		}

		return false;
	}
}
