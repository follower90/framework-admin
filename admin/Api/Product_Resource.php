<?php

namespace Admin\Api;

use Core\Orm;

class Product_Resource extends \Core\Api
{

	public function methodSort($args)
	{
		$order = $args['ids'];
		$max = count($args['ids']);

		foreach ($order as $id) {
			if ($id) {
				$item = Orm::load('Product_Resource', $id);
				$item->setValue('position', --$max);
				$item->save();
			}
		}

		return ['success' => true];
	}

}
