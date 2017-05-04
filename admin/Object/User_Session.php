<?php

namespace Admin\Object;

class User_Session extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('User_Session');
			self::$_config->setFields([
				'userId' => [
					'type' => 'int',
					'default' => '',
					'null' => false,
				],
				'entity' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'hash' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}
}

