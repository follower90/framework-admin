<?php

namespace App\Api;

class Resource extends \Core\Api
{
	public function methodGet($args)
	{
		if (!$resource = \Admin\Object\Resource::find($args['id'])) {
			throw new \Core\Exception\Exception('Resource not found');
		}

		$src = $resource->getPath();
		
		if (!file_exists($src)) {
			throw new \Core\Exception\Exception('File does not exist on storage');
		}

		\Core\Library\File::upload($src, $resource->getValue('name'));
	}

	public function methodGetImageResized($args)
	{
		if (!$resource = \Admin\Object\Resource::find($args['id'])) {
			throw new \Core\Exception\Exception('Resource not found');
		}

		if (!$args['width'] || !$args['height']) {
			throw new \Core\Exception\Exception('You need to specify width and height');
		}

		$view = new \Core\View();
		$src = $resource->getPath();

		if (!file_exists($src)) {
			throw new \Core\Exception\Exception('File does not exist on storage');
		}

		$src = $view->imageResize($src, $args['width'], $args['height']);
		\Core\Library\File::upload($src, $resource->getValue('name'));
	}
}
