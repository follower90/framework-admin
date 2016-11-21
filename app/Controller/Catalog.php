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

		if (!$args['url'] || $args['url'] === 'all') {
			$products = Orm::find('Product',['active'], [1], $params)->getData();
			$catalogId = null;
		} else {
			$catalog = \Admin\Object\Catalog::findBy(['url' => $args['url']]);

			if (!$catalog) $this->render404();
			$catalogId = $catalog->getId();
			$products = $catalog->getRelated('products', $params)->getData();
		}

		$content = $this->view->render('templates/catalog.phtml', [
			'catalogs' => \Admin\Object\Catalog::where(['active' => 1])->getData(),
			'catalog' => $catalogId,
			'products' => $products,
			'sort' => $sort
		]);

		return $this->render(['content' => $content]);
	}
}
