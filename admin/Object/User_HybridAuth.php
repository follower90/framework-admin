<?php

namespace Admin\Object;

class User_HybridAuth extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('User_HybridAuth');
			self::$_config->setFields([
				'userId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'hybridauth_provider_name' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'hybridauth_provider_uid' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}
}
