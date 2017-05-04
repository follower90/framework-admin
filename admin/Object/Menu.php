<?php

namespace Admin\Object;

class Menu extends \Core\Object
{
	protected static $_config;

	const TYPE_MAIN = 1;
	const TYPE_BOTTOM = 2;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Menu');
			self::$_config->setFields([
				'languageTable' => [
					'name' => [
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
				'icon' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'type' => [
					'type' => 'tinyint',
					'default' => 1,
					'null' => false,
				],
				'parent' => [
					'type' => 'int',
					'default' => 0,
					'null' => false,
				],
				'sort' => [
					'type' => 'int',
					'default' => 0,
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

	public function getMenuType()
	{
		return static::getTypesMap()[$this->getValue('type')];
	}

	public static function getTypesMap()
	{
		return [
			static::TYPE_MAIN => \Admin\Utils::translate('Main Menu'),
			static::TYPE_BOTTOM => \Admin\Utils::translate('Bottom Menu')
		];
	}
}
