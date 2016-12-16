<?php

namespace Admin\Object;

class Delivery_Department extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Delivery_Department');
			self::$_config->setFields([
				'languageTable' => [
					'name' => [
						'type' => 'varchar',
						'default' => '',
						'null' => false,
					],
				],
				'deliveryTypeId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}
}
