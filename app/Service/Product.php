<?php

namespace App\Service;

use Core\Database\PDO;

class Product
{
	public static function filterBy($catalog = null, $filters = [], $sort = '')
	{
		$db = PDO::getInstance();
		$productFilters = ['active' => 1];
		$params = [];

		if (!empty($sort)) {
			$params = ['sort' => explode(':', $sort)];
		}

		if (is_array($filters) && !empty($filters)) {
			$filterProducts = $db->rows('select Product from Product__Filter where Filter in(?)', [implode(',', $filters)]);

			if (!empty($filterProducts)) {
				$productFilters['id'] = array_column($filterProducts, 'Product');
			}
		}

		if ($catalog) {
			$catalog = \Admin\Object\Catalog::findBy(['url' => $args['url']]);
			$productIds = $catalog->getRelated('products')->getValues('id');

			if (isset($productFilters['id'])) {
				$productFilters['id'][] = $productIds;
			} else {
				$productFilters['id'] = $productIds;
			}
		}

		return \Core\Orm::find('Product', array_keys($productFilters), array_values($productFilters), $params);
	}
}