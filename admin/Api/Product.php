<?php

namespace Admin\Api;

use Admin\Object\Object_Resource;
use Admin\Object\Product_Resource;
use Core\Library\File;
use Core\App;
use Core\Orm;

class Product extends \Core\Api
{
	public function methodActive($args)
	{
		if (!$args['id']) return false;
		$admin = \Admin\Object\Product::find($args['id']);
		$admin->setValue('active', (int)$args['active']);
		$admin->save();

		return ['success' => true];
	}

	public function methodUploadPhoto($args)
	{
		$data = explode(',', $args['file']);
		$data = base64_decode($data[1]);

		$productResource = Orm::findOne('Product_Resource', ['productId', 'type', 'position'], [$args['id'], Product_Resource::TYPE_PHOTO, $args['position']]);
		if ($productResource) {
			Orm::delete($productResource);
			Object_Resource::removeResources($productResource->getId(), 'product_resource', Object_Resource::TYPE_PHOTO_ORIGINAL);
		}

		$productResource = new Product_Resource([
			'productId' => $args['id'],
			'type' => Product_Resource::TYPE_PHOTO,
			'position' => $args['position']
		]);

		$productResource->save();

		$tmpOriginal = App::get()->getAppPath() . '/tmp/' . $args['original'];
		File::put('/storage/product_resource/' . $productResource->getId() . '/' . $args['original'], file_get_contents($tmpOriginal));

		Object_Resource::saveResource($productResource->getId(), 'product_resource', Object_Resource::TYPE_PHOTO_ORIGINAL, $args['original']);

		File::put('/storage/product_resource/' . $productResource->getId() . '/' . 'photo_' . $args['position'] . '.jpg', $data);
		Object_Resource::saveResource($productResource->getId(), 'product_resource', Object_Resource::TYPE_PHOTO, 'photo_' . $args['position'] . '.jpg');
		return ['success' => true];
	}

	public function methodUploadAdditionalPhoto($args)
	{
		$data = explode(',', $args['file']);
		$data = base64_decode($data[1]);

		$existingResource = Orm::findOne('Product_Resource', ['productId', 'type'], [$args['id'], Product_Resource::TYPE_PHOTO_ADDITIONAL], ['sort' => ['position', 'desc']]);
		$position = $existingResource ? $existingResource->getValue('position') + 1 : 1;

		$productResource = new Product_Resource([
			'productId' => $args['id'],
			'type' => Product_Resource::TYPE_PHOTO_ADDITIONAL,
			'position' => $position
		]);

		$productResource->save();

		$tmpOriginal = App::get()->getAppPath() . '/tmp/' . $args['original'];
		File::put('/storage/product_resource/' . $productResource->getId() . '/' . $args['original'], file_get_contents($tmpOriginal));

		Object_Resource::saveResource($productResource->getId(), 'product_resource', Object_Resource::TYPE_PHOTO_ORIGINAL, $args['original']);

		File::put('/storage/product_resource/' . $productResource->getId() . '/' . 'photo_' . $position . '.jpg', $data);
		$id = Object_Resource::saveResource($productResource->getId(), 'product_resource', Object_Resource::TYPE_PHOTO, 'photo_' . $position . '.jpg');

		return ['id' => $id];
	}

	public function methodRemoveAdditionalPhoto($args)
	{
		$objectResource = Orm::findOne('Object_Resource', ['resourceId'], [$args['id']]);

		if ($objectResource) {
			$productResource = Orm::load('Product_Resource', $objectResource->getValue('objectId'));
			Object_Resource::removeResources($productResource->getId(), 'product_resource', Object_Resource::TYPE_PHOTO);
			Object_Resource::removeResources($productResource->getId(), 'product_resource', Object_Resource::TYPE_PHOTO_ORIGINAL);

			Orm::delete($productResource);
		}

		return ['success' => true];
	}
}
