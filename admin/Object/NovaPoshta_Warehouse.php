<?php

namespace Admin\Object;

class NovaPoshta_Warehouse extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('NovaPoshta_Warehouse');
			self::$_config->setFields([
				'name_ru' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'name_ua' => [
					'type' => 'varchar',
					'default' => '',
					'null' => true,
				],
				'ref' => [
					'type' => 'varchar',
					'default' => '',
					'null' => true,
				],
				'cityRef' => [
					'type' => 'varchar',
					'default' => '',
					'null' => true,
				],
			]);
		}

		return self::$_config;
	}
}
