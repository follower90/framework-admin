<?php

namespace Admin\Object;

class Setting extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Admin');
			self::$_config->setFields([
				'key' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'value' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}

	public static function get($key)
	{
		$object = \Core\Orm::findOne('Setting', ['key'], [$key]);
		return $object ? $object->getValue('value') : false;
	}

	public static function put($key, $value)
	{
		$object = \Core\Orm::findOne('Setting', ['key'], [$key]);
		if (!$object) {
			$object = new self();
			$object->setValue('key', $key);
		}

		$object->setValue('value', $value);
		$object->save();
	}
}
