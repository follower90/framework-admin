<?php

namespace Admin\Object;

use Core\Orm;
use Core\Library\File;

class Object_Resource extends \Core\Object
{
	const TYPE_PHOTO = 1;
	const TYPE_PHOTO_ORIGINAL = 2;

	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Object_Resource');
			self::$_config->setFields([
				'resourceId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'objectType' => [
					'type' => 'varchar',
					'default' => null,
					'null' => false,
				],
				'objectId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'type' => [
					'type' => 'tinyint',
					'default' => null,
					'null' => false,
				],
			]);
		}

		return self::$_config;
	}

	public function remove()
	{
		$resource = Orm::load('Resource', $this->getValue('resourceId'));

		if ($resource) {
			File::delete(\Core\App::get()->getAppPath() . $resource->getValue('src'));
			Orm::delete($resource);
		}

		Orm::delete($this);
	}

	public static function removeResources($objectId, $objectType, $type)
	{
		$existingResources = Orm::find('Object_Resource', ['objectType', 'objectId', 'type'], [$objectId, $objectType, $type]);
		if ($existingResources->getCount() > 0) {
			foreach ($existingResources->getCollection() as $obj) {
				$obj->remove();
			}
		}
	}

	public static function saveResource($objectId, $objectType, $type, $filename)
	{
		$existingResource = Orm::findOne('Object_Resource', ['objectType', 'objectId', 'type'], [$objectType, $objectId, $type]);

		if ($existingResource) {
			$resource = Orm::load('Resource', $existingResource->getValue('resourceId'));
			if ($resource) {
				Orm::delete($resource);
			}

			Orm::delete($existingResource);
		}

		$resource = Orm::create('Resource');
		$resource->setValues([
			'name' => $filename,
			'src' => '/storage/' . $objectType . '/' . $objectId . '/' . $filename
		]);

		$resource->save();

		$objectResource = new self([
			'objectId' => $objectId,
			'objectType' => $objectType,
			'resourceId' => $resource->getId(),
			'type' => $type
		]);

		$objectResource->save();
	}
}
