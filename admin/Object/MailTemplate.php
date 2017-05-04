<?php

namespace Admin\Object;

class MailTemplate extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('MailTemplate');
			self::$_config->setFields([
				'languageTable' => [
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
				],
				'alias' => [
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

	public static function get($alias)
	{
		return self::findBy(['alias' => $alias]);
	}
}
