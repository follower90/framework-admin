<?php

namespace App\Service;

use Core\Database\PDO;
use Core\Exception\Exception;
use Core\Orm;

class Product
{
	public static function filterBy($catalogId = null, $filters = [], $sort = '', $page = 0, $where = [])
	{
		$db = PDO::getInstance();

		$catalogOnPage = 50;
		$productFilters = ['active' => 1];
		$params = [];

		if (!empty($sort)) {
			$params = ['sort' => explode(':', $sort)];
		}

		if ($catalogId) {
			$catalog = Orm::load('Catalog', $catalogId);
			if (!$catalog) {
				throw new Exception('Incorrect catalog');
			}

			$productIds = $catalog->getRelated('products')->getValues('id');
			if (is_array($filters) && !empty($filters)) {

				$filterProducts = $db->rows('select Product, group_concat(Filter) as Filter from Product__Filter where Product in(' . implode(',', $productIds) . ') group By Product');

				foreach ($filterProducts as $filterProduct) {
					$filterInProduct = explode(',', $filterProduct['Filter']);
					$matching = true;

					foreach ($filters as $filterGroup) {
						$matchingGroup = false;
						foreach ($filterGroup as $filter) {
							if (in_array($filter, $filterInProduct)) {
								$matchingGroup = true;
							}
						}

						if (!$matchingGroup) $matching = false;
					}

					if ($matching) {
						if (!isset($productFilters['id'])) $productFilters['id'] = [];
						array_push($productFilters['id'], $filterProduct['Product']);
					}
				}
			} else {
				$productFilters['id'] = $productIds;
			}
		}

		if (!empty($where)) {
			$productFilters = array_merge($productFilters, $where);
		}

		if ($page) {
			$params['limit'] = $catalogOnPage;
			$params['offset'] = ($page - 1) * $catalogOnPage;
		}

		$products = Orm::find('Product', array_keys($productFilters), array_values($productFilters), $params);

		$result = [
			'products' => $products,
			'products_all' => $products,
			'total' => count($products->getData())
		];

		if ($page) {
			$result['products_all'] = Orm::find('Product', array_keys($productFilters), array_values($productFilters));
			$result['total'] = Orm::count('Product', array_keys($productFilters), array_values($productFilters));
		}

		return $result;
	}

	public static function getAvailableFiltersDataForCatalog($catalogId, $products, $selectedFilters)
	{
		$catalog = Orm::load('Catalog', $catalogId);
		if (!$catalog) return [];

		$data = [];

		$filterSets = $catalog
			->getRelated('products')
			->getRelated('filters')
			->getRelated('filter_set');

		foreach ($filterSets->getCollection() as $filterSet) {
			$filterSetId = $filterSet->getId();
			$filters = Orm::find('Filter', ['filterSetId'], [$filterSetId]);
			$data[$filterSetId] = $filterSet->getValues();

			foreach ($filters->getCollection() as $filter) {
				$data[$filterSetId]['filters'][$filter->getId()] = $filter->getValues();
				$data[$filterSetId]['filters'][$filter->getId()]['count'] = self::getFilterCountsForSet($catalogId, $filter, $selectedFilters, $products->getCount());
			}
		}

		return $data;

	}

	public static function getFilterCountsForSet($catalogId, $filter, $selectedFilters, $productCount)
	{
		$filterId = $filter->getId();
		$filterSetId = $filter->getValue('filterSetId');

		if (in_array($filterId, $selectedFilters[$filterSetId])) {
			return '*';
		}

		if (!$selectedFilters[$filterSetId]) {
			$filters[$filterSetId] = [];
		}

		$selectedFilters[$filterSetId][] = $filterId;
		$productsFiltered = self::filterBy($catalogId, $selectedFilters);

		return $productCount >= $productsFiltered['total']
			? $productsFiltered['total']
			: $productsFiltered['total'] - $productCount;
	}

	public static function viewPrice($basicPrice)
	{
		$currencies = Orm::find('Currency');

		$currency = $currencies->stream()->filter(function ($obj) {
			return $obj->getId() == \Core\Config::get('site.currency');
		})->findFirst();

		$basicCurrency = $currencies->stream()->filter(function ($obj) {
			return $obj->getValue('basic') == 1;
		})->findFirst();

		$price = number_format($basicPrice / $basicCurrency->getValue('rate') * $currency->getValue('rate'), 2);

		return $currency->getValue('position') == \Admin\Object\Currency::SYMBOL_RIGHT
			? $price . ' ' . $currency->getValue('symbol')
			: $currency->getValue('symbol') . ' ' . $price;
	}

	public static function getByProductCategory($category, $limit)
	{
		$db = PDO::getInstance();
		$category = \Admin\Object\ProductCategory::findBy(['url' => $category]);
		$filterProducts = $db->rows('select Product as id from Product__ProductCategory where ProductCategory=' . $category->getId());

		return Orm::find('Product', ['active', 'id'], [1, array_column($filterProducts, 'id')], ['limit' => $limit]);
	}
}