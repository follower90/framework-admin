<?php

namespace Admin\Api;

use Admin\Object\Photo;
use Core\Orm;

class Photo_Album extends \Core\Api
{
	public function methodActive($args)
	{
		if (!$args['id']) return false;
		$page = Orm::load('Photo_Album', $args['id']);
		$page->setValue('active', (int)$args['active']);
		Orm::save($page);

		return ['success' => true];
	}

	public function methodRemovePhoto($args)
	{
		$photo = Orm::findOne('Photo', ['albumId', 'lang.name'], [$args['id'], $args['filename']]);
		$resource = Orm::load('Resource', $photo->getValue('resourceId'));

		\Core\Library\File::delete($resource->getValue('src'));

		$resource->delete();
		$photo->delete();
	}

	public function methodUpload($args)
	{
		$file = \Core\Library\File::request()['file'];
		$path = '/storage/photos/' . $args['id'] . '/' . $file['name'];

		$resource = \Admin\Object\Resource::createResourceFromUpload($file, $path);

		$photo = new Photo([
			'albumId' => $args['id'],
			'resourceId' => $resource->getId(),
			'name' => $file['name']
		]);

		$photo->save();
	}

	public function methodPhotos($args)
	{
		$photos = Orm::find('Photo', ['albumId'], [$args['id']]);
		$data = Orm::find('Resource', ['id'], [$photos->getValues('resourceId')])->getData();

		foreach ($data as &$item) {
			$item['name'] = $photos->findFirstBy('resourceId', $item['id'])->getValue('name');
		}
		return $data;
	}

}
