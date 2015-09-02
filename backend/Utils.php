<?php

namespace Admin;

class Utils
{
	public static function translate($key)
	{
		if ($data = \Core\Orm::findOne('Translation', ['alias'], [$key])) {
			return $data->getValue('value');
		}

		return false;
	}
}
