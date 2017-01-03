<?php

namespace App\Api;

class Comments extends \Core\Api
{
	public function methodList($args)
	{
		return \App\Service\Comments::load($args['type'], $args['id'])->getComments();
	}

	public function methodPost($args)
	{
		$service = \App\Service\Comments::load($args['type'], $args['id']);
		$service->addComment($args['text']);
	}
}
