<?php

namespace Admin\Object;

class Favourite extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Favourite');
			self::$_config->setFields([
				'userId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'session' => [
					'type' => 'varchar',
					'default' => null,
					'null' => false,
				],
				'entity' => [
					'type' => 'varchar',
					'default' => null,
					'null' => false,
				],
				'entityId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				]
			]);
		}

		return self::$_config;
	}
}
