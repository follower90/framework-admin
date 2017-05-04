<?php

namespace Admin\Service;

use Core\App;
use Core\Library\File;

use Admin\Object\Object_Resource;

class Catalog
{
	public static function uploadPhoto($catalogId, $pathOriginal, $data)
	{
		$tmpOriginal = App::get()->getAppPath() . '/tmp/' . $pathOriginal;
		$origPhotoPath = '/storage/catalog/' . $catalogId . '/' . $pathOriginal;
		File::put($origPhotoPath, file_get_contents($tmpOriginal));

		Object_Resource::removeResources($catalogId, 'catalog', Object_Resource::TYPE_PHOTO_ORIGINAL);
		Object_Resource::saveResource($catalogId, 'catalog', Object_Resource::TYPE_PHOTO_ORIGINAL, $origPhotoPath);

		$photoPath = '/storage/catalog/' . $catalogId . '/' . 'photo.jpg';

		File::put($photoPath, $data);
		Object_Resource::saveResource($catalogId, 'catalog', Object_Resource::TYPE_PHOTO, $photoPath);
	}
}
