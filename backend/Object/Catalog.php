<?php

namespace Admin\Object;

class Catalog extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Catalog');
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
				'url' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'parent' => [
					'type' => 'int',
					'default' => 0,
					'null' => false,
				],
				'active' => [
					'type' => 'tinyint',
					'default' => 0,
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}
}
