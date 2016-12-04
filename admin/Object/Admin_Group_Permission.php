<?php

namespace Admin\Object;

class Admin_Group_Permission extends \Core\Object
{
	const DENY = 0;
	const VIEW = 1;
	const MANAGE = 2;

	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Admin_Group_Permission');
			self::$_config->setFields([
				'groupId' => [
					'type' => 'int',
					'default' => null,
					'null' => true,
				],
				'moduleId' => [
					'type' => 'varchar',
					'default' => null,
					'null' => false,
				],
				'permission' => [
					'type' => 'tinyint',
					'default' => 0,
					'null' => false,
				]
			]);
		}

		return self::$_config;
	}

	public static function getPermissionsMap()
	{
		return [
			static::DENY => i18n('Deny'),
			static::VIEW => i18n('View'),
			static::MANAGE => i18n('Manage'),
		];
	}
}
