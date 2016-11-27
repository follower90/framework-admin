<?php

namespace App\Controller;

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

		$content = $this->view->render('templates/catalog/catalog.phtml', [
			'catalogs' => \Admin\Object\Catalog::where(['active' => 1])->getData(),
			'catalog' => $catalogId,
			'filters' => \App\Service\Product::getAvailableFilters($products),
			'products' => $products->getData(),
			'checked_filters' => $filters,
			'sort' => $sort
		]);

		$this->addJavaScriptPath(['/js/catalog.js']);
		return $this->render(['content' => $content]);
	}
}
