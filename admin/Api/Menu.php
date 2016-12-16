<?php

namespace Admin\Api;

use Core\Orm;

class Menu extends \Core\Api
{
	public function methodActive($args)
	{
		if (!$args['id']) return false;
		$page = Orm::load('Menu', $args['id']);
		$page->setValue('active', (int)$args['active']);
		Orm::save($page);

		return ['success' => true];
	}

}
