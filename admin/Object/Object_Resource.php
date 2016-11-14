<?php

namespace Admin\Object;

abstract class Object_Resource extends \Core\Object
{
	protected static $_config;

	const TYPE_PHOTO = 1;
	const TYPE_PHOTO_ORIG = 2;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
		}

		return self::$_config;
	}
}