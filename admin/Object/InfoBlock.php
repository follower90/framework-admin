<?php

namespace Admin\Object;

class InfoBlock extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('InfoBlock');
			self::$_config->setFields([
				'languageTable' => [
					'name' => [
						'type' => 'varchar',
						'default' => '',
						'null' => false,
					],
					'text' => [
						'type' => 'text',
						'default' => '',
						'null' => false,
					],
				],
				'alias' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				]
			]);
		}

		return self::$_config;
	}

	public static function get($key)
	{
		return \Core\Orm::findOne('InfoBlock', ['alias'], [$key]);
	}

	public static function getText($key)
	{
		$object = static::get($key);
		return $object ? $object->getValue('text') : false;
	}
}
