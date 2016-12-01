<?php

namespace Admin\Object;

class Admin extends \Admin\Object\User
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Admin');
			self::$_config->setFields([
				'name' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'groupId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'active' => [
					'type' => 'tinyint',
					'default' => 1,
					'null' => false,
				],
			]);
		}

		\Core\Orm::registerRelation(
			['type' => 'has_one', 'alias' => 'admin_group', 'table' => 'Admin_Group'],
			['class' => 'Admin', 'field' => 'groupId'],
			['class' => 'Admin_Group', 'field' => 'id']
		);

		return self::$_config;
	}

	public static function hashPassword($password)
	{
		return md5('2wegdge23t2' . $password . 'Uyh920ht8');
	}
}
