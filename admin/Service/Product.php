<?php

namespace Admin\Service;

use Core\Orm;
use Core\App;
use Core\Library\File;

use Admin\Object\Product_Resource;
use Admin\Object\Object_Resource;

class Product
{
	public static function savePhoto($productId, $origPath, $data)
	{
		$existingResource = Orm::findOne('Product_Resource', ['productId', 'type'], [$productId, Product_Resource::TYPE_PHOTO], ['sort' => ['position', 'desc']]);
		$position = $existingResource ? $existingResource->getValue('position') + 1 : 1;

		$productResource = new Product_Resource([
			'productId' => $productId,
			'type' => Product_Resource::TYPE_PHOTO
		]);

		$productResource->save();

		$tmpOriginal = App::get()->getAppPath() . '/tmp/' . $origPath;
		$origPhotoPath = '/storage/product/' . $productId . '/product_resource/' . $productResource->getId() . '/' . $origPath;
		File::put($origPhotoPath, file_get_contents($tmpOriginal));

		Object_Resource::saveResource($productResource->getId(), 'product_resource', Object_Resource::TYPE_PHOTO_ORIGINAL, $origPhotoPath);

		$path = '/storage/product/' . $productId . '/product_resource/' . $productResource->getId() . '/' . 'photo_' . $position . '.jpg';

		File::put($path, $data);
		$resourceId = Object_Resource::saveResource($productResource->getId(), 'product_resource', Object_Resource::TYPE_PHOTO, $path);

		return [
			'resourceId' => $resourceId,
			'productResourceId' => $productResource->getId()
		];
	}
}