<?php

namespace Admin\Api;

use Admin\Object\Object_Resource;
use Core\Library\File;
use Core\App;
use Core\Orm;

class Catalog extends \Core\Api
{
	public function methodActive($args)
	{
		if (!$args['id']) return false;
		$admin = \Admin\Object\Catalog::find($args['id']);
		$admin->setValue('active', (int)$args['active']);
		$admin->save();

		return ['success' => true];
	}

	public function methodUploadPhoto($args)
	{
		$data = explode(',', $args['file']);
		$data = base64_decode($data[1]);

		\Admin\Service\Catalog::uploadPhoto($args['id'], $args['original'], $data);
		return ['success' => true];
	}
}
