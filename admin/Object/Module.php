<?php

namespace Admin\Object;

class Module extends \Core\Object
{
	protected static $_config;

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
}
