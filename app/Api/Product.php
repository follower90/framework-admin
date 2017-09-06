<?php

namespace App\Api;

use Core\Orm;

class Product extends \Core\Api
{
	public function methodSearch($args)
	{
		$limit = $args['limit'] || 10;
		if (!$args['search'] || strlen($args['search']) < 3) {
			return [];
		}

		$items = Orm::find('Product', ['~lang.name'], [$args['search']], ['limit' => $limit]);
		return $items->getData();
	}
}
