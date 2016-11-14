<?php

namespace Admin\Api;

class File extends \Core\Api
{
	public function methodUpload($args)
	{
		$dir = '/storage/' . $args['type'] . '/' . $args['id'];
		\Core\Library\Dir::create($dir);

		$file = \Core\Library\File::request()['file'];
		$path = $dir . '/' . $file['name'];
		\Core\Library\File::saveUploadedFile($file['tmp_name'], $path);

		return ['src' => $path];
	}
}
