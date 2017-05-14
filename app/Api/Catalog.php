<?php

namespace App\Api;

use Core\View;

class Catalog extends \Core\Api
{
	public function methodProducts($args)
	{
		$where = [];

		if ($args['search']) {
			$where['~lang.name'] = '%' . $args['search'] . '%';
		}

		$products = \App\Service\Product::filterBy($args['catalog'], $args['filters'], $args['sort'], $args['page'], $where);
		$filters = \App\Service\Product::getAvailableFiltersDataForCatalog($args['catalog'], $products['products_all'], $args['filters']);

		$view = new View();
		$view->setDefaultPath('public/fashion');

		return [
			'products' => $view->render('templates/catalog/products.phtml', [
				'products' => $products['products']->getData(),
				'total' => $products['total'],
				'args' => $args['args']
			]),

			'paging' => $view->render('templates/catalog/paging.phtml', [
				'page' => $args['page'],
				'total' => $products['total'],
				'onpage' => 50
			]),

			'filters' => $view->render('templates/catalog/products_filters.phtml', [
				'filters' => $filters,
				'checked_filters' => $args['filters']
			])
		];
	}
}
