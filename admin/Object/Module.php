<?php

namespace Admin\Object;

class Module extends \Core\Object
{
	protected static $_config;

	const TYPE_HIDDEN = 0;
	const TYPE_WEBSITE = 1;
	const TYPE_SHOP = 2;
	const TYPE_ADMIN = 3;
	const TYPE_SEO = 4;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Module');
			self::$_config->setFields([
				'languageTable' => [
					'name' => [
						'type' => 'varchar',
						'default' => '',
						'null' => false,
					],
					'description' => [
						'type' => 'text',
						'default' => '',
						'null' => false,
					],
				],
				'type' => [
					'type' => 'tinyint',
					'default' => 0,
					'null' => false,
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
				]
			]);
		}

		return self::$_config;
	}

	public function validate()
	{
		if (trim($this->getValue('url')) === '') {
			$this->setError('URL is required');
			return false;
		}

		return true;
	}

	public function getType()
	{
		return static::getTypesMap()[$this->getValue('type')];
	}

	public static function getTypesMap()
	{
		return [
			static::TYPE_HIDDEN => __('Hidden'),
			static::TYPE_WEBSITE => __('Web Site'),
			static::TYPE_SHOP => __('Online Shop'),
			static::TYPE_ADMIN => __('Administration'),
			static::TYPE_SEO => __('SEO'),
		];
	}
}
