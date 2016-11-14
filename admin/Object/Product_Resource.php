<?php

namespace Admin\Object;

use Core\Orm;
use Core\Library\File;

class Product_Resource extends Object_Resource
{
	protected static $_config;

	public function getConfig()
	{
		if (empty(self::$_config)) {
			self::$_config = clone parent::getConfig();
			self::$_config->setTable('Product_Resource');
			self::$_config->setFields([
				'resourceId' => [
					'type' => 'int',
					'default' => null,
					'null' => false,
				],
				'productId' => [
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

	public static function removeSources($productId, $type)
	{
		$existingResources = Orm::find('Product_Resource', ['productId', 'type'], [$productId, $type]);
		if ($existingResources->getCount() > 0) {
			foreach ($existingResources->getCollection() as $obj) {
				$resource = Orm::load('Resource', $obj->getValue('resourceId'));

				if ($resource) {
					File::delete(\Core\App::get()->getAppPath() . $resource->getValue('src'));
					Orm::delete($resource);
				}

				Orm::delete($obj);
			}
		}
	}

	public static function saveResource($productId, $type, $filename)
	{
		$existingResource = Orm::findOne('Product_Resource', ['productId', 'type'], [$productId, $type]);

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
			'src' => '/storage/product/' . $productId . '/' . $filename
		]);

		$resource->save();

		$productResource = Orm::create('Product_Resource');
		$productResource->setValues([
			'productId' => $productId,
			'resourceId' => $resource->getId(),
			'type' => $type
		]);

		$productResource->save();
	}
}
