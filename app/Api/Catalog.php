<?php

namespace App\Api;

use Core\View;

class Catalog extends \Core\Api
{
	public function methodProducts($args)
	{
		$products = \App\Service\Product::filterBy($args['catalog'], $args['filters'], $args['sort']);
		$filters = \App\Service\Product::getAvailableFiltersDataForCatalog($args['catalog'], $products);

		$view = new View();
		$view->setDefaultPath('public/app');

		return [
			'products' => $view->render('templates/catalog/products_list.phtml', ['products' => $products->getData()]),
			'filters' => $view->render('templates/catalog/products_filters.phtml', ['filters' => $filters, 'checked_filters' => $args['filters']])
		];
	}
}
