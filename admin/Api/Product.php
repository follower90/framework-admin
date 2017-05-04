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

		return \Admin\Service\Product::savePhoto($args['id'], $args['original'], $data);
	}

	public function methodUploadPhotoPreview($args)
	{
		$data = explode(',', $args['file']);
		$data = base64_decode($data[1]);

		$productResourceId = Orm::findOne('Object_Resource', ['resourceId'], [$args['resourceId']])->getValue('objectId');

		$path = '/storage/product/' . $args['id'] . '/product_resource/' . $productResourceId . '/preview.jpg';

		File::put($path, $data);
		Object_Resource::saveResource($productResourceId, 'product_resource', Object_Resource::TYPE_PHOTO_PREVIEW, $path);

		return ['success' => true];
	}

	public function methodRemovePhoto($args)
	{
		$objectResource = Orm::findOne('Object_Resource', ['resourceId'], [$args['id']]);

		if ($objectResource) {
			$productResource = Orm::load('Product_Resource', $objectResource->getValue('objectId'));

			Object_Resource::removeResources($productResource->getId(), 'product_resource', Object_Resource::TYPE_PHOTO);
			Object_Resource::removeResources($productResource->getId(), 'product_resource', Object_Resource::TYPE_PHOTO_PREVIEW);
			Object_Resource::removeResources($productResource->getId(), 'product_resource', Object_Resource::TYPE_PHOTO_ORIGINAL);

			Orm::delete($productResource);
		}

		return ['success' => true];
	}
}
