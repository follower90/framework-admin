<?php

namespace Admin\Object;

class Meta extends \Core\Object
{
	protected static $_config;

	const TYPE_DEFAULT = 1;
	const TYPE_PREFIX = 2;
	const TYPE_SUFFIX = 3;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Meta');
			self::$_config->setFields([
				'languageTable' => [
					'title' => [
						'type' => 'varchar',
						'default' => '',
						'null' => false,
					],
					'keywords' => [
						'type' => 'varchar',
						'default' => '',
						'null' => false,
					],
					'description' => [
						'type' => 'varchar',
						'default' => '',
						'null' => false,
					],
				],
				'url' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'type' => [
					'type' => 'tinyint',
					'default' => 1,
					'null' => false,
				],
				'moduleId' => [
					'type' => 'int',
					'default' => 0,
					'null' => false,
				]
			]);
		}

		return self::$_config;
	}
}
