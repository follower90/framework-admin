<?php

namespace Core\Object;

class Resource extends \Core\Object
{
	protected static $_config;

	const TYPE_CATALOG = 1;
	const TYPE_PRODUCT = 2;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Resource');
			self::$_config->setFields([
				'type' => [
					'type' => 'tinyint',
					'default' => null,
					'null' => false,
				],
				'resource_id' => [
					'type' => 'int',
					'default' => '',
					'null' => false,
				],
				'entity_id' => [
					'type' => 'int',
					'default' => '',
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}
}
