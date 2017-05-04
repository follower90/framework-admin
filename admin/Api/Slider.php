<?php

namespace Admin\Api;

use Admin\Object\Object_Resource;
use Core\Library\File;
use Core\App;

class Slider extends \Core\Api
{
	public function methodActive($args)
	{
		if (!$args['id']) return false;
		$admin = \Admin\Object\Slider::find($args['id']);
		$admin->setValue('active', (int)$args['active']);
		$admin->save();

		return ['success' => true];
	}

	public function methodUploadPhoto($args)
	{
		$data = explode(',', $args['file']);
		$data = base64_decode($data[1]);

		$path = '/storage/slider/' . $args['id'] . '/' . 'photo.jpg';
		File::put($path, $data);
		Object_Resource::saveResource($args['id'], 'slider', Object_Resource::TYPE_PHOTO, $path);
		return ['success' => true];
	}
}
