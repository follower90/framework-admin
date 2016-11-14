<?php

namespace Admin\Api;

class File extends \Core\Api
{
	public function methodUpload($args)
	{
		$file = \Core\Library\File::request()['file'];
		$path = '/tmp/' . $file['name'];
		\Core\Library\File::saveUploadedFile($file['tmp_name'], $path);

		return ['src' => $path];
	}
}
