<?php

namespace Admin\Api;

use Core\Orm;

class Page extends \Core\Api
{
	public function methodActive($args)
	{
		if (!$args['id']) return false;
		$page = Orm::load('Page', $args['id']);
		$page->setValue('active', (int)$args['active']);
		Orm::save($page);

		return ['success' => true];
	}

}
