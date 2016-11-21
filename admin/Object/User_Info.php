<?php

namespace Admin\Object;

class User_Info extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('User_Info');
			self::$_config->setFields([
				'userId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'email' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'firstName' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'lastName' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'phone' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'address' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				]
			]);

			\Core\Orm::registerRelation(
				['type' => 'has_one', 'alias' => 'info', 'table' => 'User_Info'],
				['class' => 'User', 'field' => 'id'],
				['class' => 'User_Info', 'field' => 'userId']
			);
		}

		return self::$_config;
	}
}

