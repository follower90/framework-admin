<?php

namespace App\Controller;

use Core\Orm;

class Catalog extends Controller
{
	public function methodIndex($args)
	{
		$sort = isset($args['sort']) ? $args['sort'] : '';
		$filters = isset($args['filters']) ? $args['filters'] : [];

		if (!$args['url'] || $args['url'] === 'all') {
			$catalogId = null;
		} else {
			$catalog = \Admin\Object\Catalog::findBy(['url' => $args['url']]);
			if (!$catalog) $this->render404();
			$catalogId = $catalog->getId();
		}

		$products = \App\Service\Product::filterBy($catalogId, $filters, $sort);

		$content = $this->view->render('templates/catalog.phtml', [
			'catalogs' => \Admin\Object\Catalog::where(['active' => 1])->getData(),
			'catalog' => $catalogId,
			'filters' => $this->filtersData($products),
			'products' => $products->getData(),
			'checked_filters' => $args['filter'],
			'sort' => $sort
		]);

		return $this->render(['content' => $content]);
	}

	private function filtersData($products)
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
