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

		$allProducts = $catalog
			->getRelated('products');

		$filterSets = $allProducts
			->getRelated('filters')
			->getRelated('filter_set');

		foreach ($filterSets->getCollection() as $filterSet) {
			$filters = Orm::find('Filter', ['filterSetId'], [$filterSet->getId()]);
			$data[$filterSet->getId()] = $filterSet->getValues();

			foreach ($filters->getCollection() as $filter) {
				$data[$filterSet->getId()]['filters'][$filter->getId()] = $filter->getValues();
				$data[$filterSet->getId()]['filters'][$filter->getId()]['count'] = self::getFilterCountsForSet($catalogId, $products, $selectedFilters, $filter);
			}
		}

		return $data;
	}

	public static function getFilterCountsForSet($catalogId, $products, $filters, $filter)
	{
		$filterId = $filter->getId();
		$filterSetId = $filter->getValue('filterSetId');

		if (in_array($filterId, $filters[$filterSetId])) {
			return '*';
		}

		if (!$filters[$filterSetId]) $filters[$filterSetId] = [];
		$filters[$filterSetId][] = $filterId;

		$productsFiltered = self::filterBy($catalogId, $filters);

		return $products->getCount() >= $productsFiltered['total']
			? $productsFiltered['total']
			: $productsFiltered['total'] - $products->getCount();
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