<?php

namespace Admin\Object;

use Core\Orm;

class User extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('User');
			self::$_config->setFields([
				'login' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'password' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'active' => [
					'type' => 'tinyint',
					'default' => 1,
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}

	public function getValues()
	{
		$data = parent::getValues();
		$data['info'] = Orm::findOne('User_Info', ['userId'], [$this->getId()])->getValues();

		return $data;
	}
}

