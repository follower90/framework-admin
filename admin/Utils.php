<?php

namespace Admin;

use \Core\Config;
use \Core\Cookie;

class Utils
{
	public static function translate($key)
	{
		if ($data = \Core\Orm::findOne('Translation', ['alias'], [$key])) {
			return $data->getValue('value') ? $data->getValue('value') : $key;
		}

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
