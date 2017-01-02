<?php

namespace Admin\Object;

class Feedback extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Feedback');
			self::$_config->setFields([
				'date' => [
					'type' => 'datetime',
					'default' => 'CURRENT_TIMESTAMP',
					'null' => false,
				],
				'name' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'email' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'subject' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'body' => [
					'type' => 'text',
					'default' => '',
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}
}
