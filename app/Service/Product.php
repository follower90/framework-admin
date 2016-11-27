<?php

namespace App\Service;

use Core\Database\PDO;
use Core\Exception\Exception;
use Core\Orm;

class Product
{
	public static function filterBy($catalogId = null, $filters = [], $sort = '')
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

		if ($catalogId) {
			$catalog = Orm::load('Catalog', $catalogId);
			if (!$catalog) {
				throw new Exception('Incorrect catalog');
			}

			$productIds = $catalog->getRelated('products')->getValues('id');
			if (isset($productFilters['id'])) {
				$productFilters['id'][] = $productIds;
			} else {
				$productFilters['id'] = $productIds;
			}
		}

		return Orm::find('Product', array_keys($productFilters), array_values($productFilters), $params);
	}

	public static function getAvailableFilters($products)
	{
		$filters = [];
		foreach ($products->getCollection() as $product) {
			foreach ($product->getFilters()->getCollection() as $filter) {
				array_push($filters, $filter->getValues());
			}
		}

		$filterSets = [];

		foreach ($filters as $filter) {
			$set = Orm::load('FilterSet', $filter['filterSetId'])->getValues();

			if (!isset($filterSets[$set['id']])) {
				$filterSets[$set['id']] = $set;
			}

			$filterSets[$set['id']]['filters'][] = $filter;
		}

		return $filterSets;
	}
}