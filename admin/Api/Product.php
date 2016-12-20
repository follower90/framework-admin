<?php

namespace Admin\Api;

use Admin\Object\Object_Resource;
use Core\Library\File;
use Core\App;

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

		$tmpOriginal = App::get()->getAppPath() . '/tmp/' . $args['original'];
		File::put('/storage/product/' . $args['id'] . '/' . $args['original'], file_get_contents($tmpOriginal));

		Object_Resource::removeResources($args['id'], 'product', Object_Resource::TYPE_PHOTO_ORIG);
		Object_Resource::saveResource($args['id'], 'product', Object_Resource::TYPE_PHOTO_ORIG, $args['original']);

		File::put('/storage/product/' . $args['id'] . '/' . 'photo.jpg', $data);
		Object_Resource::saveResource($args['id'], 'product', Object_Resource::TYPE_PHOTO, 'photo.jpg');
		return ['success' => true];
	}
}
