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
			$content = $this->view->render('templates/catalog/catalogs_list.phtml', [
				'breadcrumbs' => $this->getBreadcrumbs(),
				'catalogs' => \Admin\Object\Catalog::where(['active' => 1])->getData()
			]);
			return $this->render(['content' => $content]);
		} else {
			$catalog = \Admin\Object\Catalog::findBy(['url' => $args['url']]);
			if (!$catalog) $this->render404();
			$catalogId = $catalog->getId();
		}

		$products = \App\Service\Product::filterBy($catalogId, $filters, $sort);

		$content = $this->view->render('templates/catalog/catalog.phtml', [
			'breadcrumbs' => $this->getBreadcrumbs($catalogId),
			'catalogs' => \Admin\Object\Catalog::where(['active' => 1])->getData(),
			'catalog' => $catalogId,
			'filters' => \App\Service\Product::getAvailableFiltersDataForCatalog($catalogId, $products),
			'products' => $products->getData(),
			'checked_filters' => $filters,
			'sort' => $sort
		]);

		$this->addJavaScriptPath(['/js/catalog.js']);
		return $this->render(['content' => $content]);
	}

	private function getBreadcrumbs($catalogId = null)
	{
		$data = [
			['url' => '/catalog/', 'name' => i18n('Catalog')]
		];

		if (!$catalogId) {
			array_push($data, ['name' => i18n('All')]);
		} else {
			$catalog = Orm::load('Catalog', $catalogId);
			array_push($data, ['name' => $catalog->getValue('name')]);
		}

		return $this->renderBreadCrumbs($data);
	}
}
