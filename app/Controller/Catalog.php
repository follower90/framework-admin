<?php

namespace App\Controller;

use Core\Orm;

class Catalog extends Controller
{
	public function methodIndex($args)
	{
		$sort = isset($args['sort']) ? $args['sort'] : '';

		switch ($sort) {
			case 'price:asc':
				$params = ['sort' => ['price', 'asc']];
				break;
			case 'price:desc':
				$params = ['sort' => ['price', 'desc']];
				break;
			default:
				$params = [];
		}

		$filterProducts = [];
		if ($args['filter']) {
			$filterProducts = $this->db->rows('select Product from Product__Filter where Filter in(?)',
			[implode(',', $args['filter'])]);
		}

		$filterParams = ['active'];
		$filterValues = [1];

		if (!empty($filterProducts)) {
			$filterParams[] = 'id';
			$filterValues[] = array_column($filterProducts, 'Product');
		}

		if (!$args['url'] || $args['url'] === 'all') {
			$catalogId = null;
		} else {
			$catalog = \Admin\Object\Catalog::findBy(['url' => $args['url']]);
			$related = $this->db->rows('select Product from Product__Catalog where Catalog =?', [$catalog->getId()]);


			$filterParams[1] = 'id';
			if (isset($filterValues[1])) {
				$filterValues[1][] = array_column($related, 'Product');
			} else $filterValues[1] = array_column($related, 'Product');

			if (!$catalog) $this->render404();
			$catalogId = $catalog->getId();
		}

		$products = Orm::find('Product', $filterParams, $filterValues, $params);

		$filters = [];
		foreach ($products->getCollection() as $product) {
			array_push($filters, $product->getFilters()->getData());
		}

		$filterSets = [];
		foreach (reset($filters) as $filter) {
			$set = Orm::load('FilterSet', $filter['filterSetId'])->getValues();

			if (!$filterSets[$set['id']]) {
				$filterSets[$set['id']] = $set;
			}

			$filterSets[$set['id']]['filters'][] = $filter;
		}

		$content = $this->view->render('templates/catalog.phtml', [
			'catalogs' => \Admin\Object\Catalog::where(['active' => 1])->getData(),
			'catalog' => $catalogId,
			'filters' => $filterSets,
			'products' => $products->getData(),
			'checked_filters' => $args['filter'],
			'sort' => $sort
		]);

		return $this->render(['content' => $content]);
	}
}
