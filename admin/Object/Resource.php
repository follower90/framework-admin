<?php

namespace Admin\Object;

use Core\App;

class Resource extends \Core\Object
{
	protected static $_config;

	const STORAGE_DEFAULT = 1;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Resource');
			self::$_config->setFields([
				'src' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'name' => [
					'type' => 'varchar',
					'default' => '',
					'null' => false,
				],
				'storageId' => [
					'type' => 'tinyint',
					'default' => 1,
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}

	public function getStoragePath()
	{
		$map = [
			1 => App::get()->getAppPath()
		];

		if (!$map[$this->getValue('storageId')]) {
			throw new \Core\Exception\Exception('Storage not found');
		}

		return $map[$this->getValue('storageId')];
	}

	public function getPath()
	{
		return $this->getStoragePath() . $this->getValue('src');
	}
}
