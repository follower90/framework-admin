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
//
//	public function methodRemovePhoto($args)
//	{
//		$photos = Orm::find('Object_Resource', ['objectId', 'objectType', 'type'], [$args['id'], 'product', Object_Resource::TYPE_PHOTO_ADITIONAL]);
//		$resource = Orm::findOne('Resource', ['src'], [$args['filename']]);
//		$photo = $photos->filterBy('resourceId', $resource->getId());
//
//		if ($resource && $photo) {
//			\Core\Library\File::delete($resource->getValue('src'));
//			$resource->delete();
//			$photo->getFirst()->delete();
//
//			return true;
//		}
//
//		return false;
//	}
//
//	public function methodExtraPhotoUpload($args)
//	{
//		$file = \Core\Library\File::request()['file'];
//		$path = '/storage/product/' . $args['id'] . '/extra/' . $file['name'];
//
//		$resource = \Admin\Object\Resource::createResourceFromUpload($file, $path);
//
//		$photo = new Object_Resource([
//			'objectType' => 'product',
//			'objectId' => $args['id'],
//			'resourceId' => $resource->getId(),
//			'type' => Object_Resource::TYPE_PHOTO_ADITIONAL,
//			'name' => $file['name']
//		]);
//
//		$photo->save();
//
//		return true;
//	}
//
//	public function methodPhotos($args)
//	{
//		$photos = Orm::find('Object_Resource', ['objectId', 'objectType', 'type'], [$args['id'], 'product', Object_Resource::TYPE_PHOTO_ADITIONAL]);
//		$data = Orm::find('Resource', ['id'], [$photos->getValues('resourceId')])->getData();
//
//		foreach ($data as &$item) {
//			$item['name'] = $item['src'];
//		}
//		return $data;
//	}

}
