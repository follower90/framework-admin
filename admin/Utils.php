<?php

namespace Admin;

use \Core\Config;
use \Core\Cookie;
use \Core\Orm;

class Utils
{
	public static function translate($key)
	{
		if ($data = Orm::findOne('Translation', ['alias'], [$key])) {
			return $data->getValue('value') ? $data->getValue('value') : $key;
		}

		$translate = Orm::create('Translation');
		$translate->setValue('alias', $key);
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
}
