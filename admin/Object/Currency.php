<?php

namespace Admin\Object;

class Currency extends \Admin\Object\User
{
	protected static $_config;

	const RELATIVE = 0;
	const BASIC = 1;

	const SYMBOL_LEFT = 1;
	const SYMBOL_RIGHT = 2;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Currency');
			self::$_config->setFields([
				'languageTable' => [
					'name' => [
						'type' => 'varchar',
						'default' => '',
						'null' => false,
					]
				],
				'symbol' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'position' => [
					'type' => 'tinyint',
					'default' => '',
					'null' => false,
				],
				'basic' => [
					'type' => 'tinyint',
					'default' => 0,
					'null' => false,
				],
				'rate' => [
					'type' => 'tinyint',
					'default' => 1,
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}
}
