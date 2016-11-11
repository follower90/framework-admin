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
				'type' => [
					'type' => 'tinyint',
					'default' => 1,
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
			1 => \Admin\Utils::translate('Main Menu'),
			2 => \Admin\Utils::translate('Bottom Menu')
		];
	}
}
