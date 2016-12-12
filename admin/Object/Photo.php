<?php

namespace Admin\Object;

class Photo extends \Core\Object
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Photo');
			self::$_config->setFields([
				'languageTable' => [
					'name' => [
						'type' => 'varchar',
						'default' => '',
						'null' => false,
					],
					'info' => [
						'type' => 'text',
						'default' => '',
						'null' => false,
					],
				],
				'albumId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'resourceId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				]
			]);
		}

		return self::$_config;
	}
}
