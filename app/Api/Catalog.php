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

		$products = \App\Service\Product::filterBy($args['catalog'], $args['filters'], $args['sort'], $where);
		$filters = \App\Service\Product::getAvailableFiltersDataForCatalog($args['catalog'], $products);

		$view = new View();
		$view->setDefaultPath('public/fashion');

		return [
			'products' => $view->render('templates/catalog/products.phtml', ['products' => $products->getData(), 'args' => $args['args']]),
			'filters' => $view->render('templates/catalog/products_filters.phtml', ['filters' => $filters, 'checked_filters' => $args['filters']])
		];
	}
}
