<?php

namespace Admin\Object;

class Translation extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Translation');
			self::$_config->setFields([
				'alias' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'type' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'languageTable' => [
					'value' => [
						'type' => 'varchar',
						'default' => '',
						'null' => false,
					],
				],
			]);
		}

		return self::$_config;
	}
}
