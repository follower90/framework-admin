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
			return $data->getValue('value') ?: $key;
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

	public static function getBasicCurrency()
	{
		return Orm::findOne('Currency', ['basic'], [1]);
	}

	private static function loadFromCache($key, $type)
	{
		$translation = File::get('/translations_cache.json');
		$data = json_decode($translation, true);
		$lang = Config::get('site.language');

		if (array_key_exists($lang, $data)
			&& array_key_exists($type, $data[$lang])
			&& array_key_exists($key, $data[$lang][$type])) {
				return $data[$lang][$type][$key];
		}

		return false;
	}
}
