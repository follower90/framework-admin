<?php

namespace App\Object;

class Test extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Test');
			self::$_config->setFields([
				'name' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}
}
