<?php

namespace App\Api;

class Resource extends \Core\Api
{
	public function methodGet($args)
	{
		if (!$resource = \Core\Object\Resource::find($args['id'])) {
			throw new \Core\Exception\Exception('Resource not found');
		}

		$src = $resource->getPath();
		
		if (!file_exists($src)) {
			throw new \Core\Exception\Exception('File does not exist on storage');
		}

		\Core\Library\File::upload($src, $resource->getValue('name'));
	}
}
