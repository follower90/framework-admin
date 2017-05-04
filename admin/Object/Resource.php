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
				'size' => [
					'type' => 'int',
					'default' => 0,
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

	public static function createResourceFromUpload($uploadedFile, $path, $storageId = 1)
	{
		\Core\Library\File::saveUploadedFile($uploadedFile['tmp_name'], $path);

		$resource = new \Admin\Object\Resource([
			'src' => $path,
			'storageId' => $storageId,
			'size' => $uploadedFile['size'],
			'name' => $uploadedFile['name'],
		]);

		$resource->save();

		return $resource;
	}
}
