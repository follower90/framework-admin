<?php

namespace App\Api;

use Core\View;

class Catalog extends \Core\Api
{
	public function methodProducts($args)
	{
		$products = \App\Service\Product::filterBy($args['catalog'], $args['filters'], $args['sort']);

		$view = new View();
		$view->setDefaultPath('public/app');

		return $view->render('templates/catalog/products_list.phtml', [
			'products' => $products->getData(),
		]);
	}
}
