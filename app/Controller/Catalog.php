<?php

namespace App\Controller;

use Core\Orm;

class Catalog extends Controller
{
	public function methodIndex($args)
	{
		$catalogOnPage = 50;

		$sort = isset($args['sort']) ? $args['sort'] : '';
		$filters = isset($args['filters']) ? $args['filters'] : [];
		$page = isset($args['page']) ? $args['page'] : 1;

		if (empty($args['url']) || $args['url'] === 'all') {
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

		$currentCatalog = Orm::load('Catalog', $catalogId);
		$products = \App\Service\Product::filterBy($catalogId, $filters, $sort, $page);

		$checkedFilters = [];
		array_map(function($arr) use (&$checkedFilters) {
			$checkedFilters = array_merge($checkedFilters, $arr);
		} , $filters);

		$content = $this->view->render('templates/catalog/catalog.phtml', [
			'breadcrumbs' => $this->getBreadcrumbs($catalogId),
			'catalogs' => \Admin\Object\Catalog::where(['active' => 1])->getData(),
			'catalogId' => $catalogId,
			'catalog' => $currentCatalog ? $currentCatalog->getValuesWithPhoto() : '',
			'filters' => \App\Service\Product::getAvailableFiltersDataForCatalog($catalogId, $products['products_all'], $filters),
			'products' => $products['products']->getData(),
			'total' => $products['total'],
			'onpage' => $catalogOnPage,
			'page' => $page,
			'checked_filters' => $checkedFilters,
			'args' => $args,
			'sort' => $sort
		]);

		$this->addJavaScriptPath(['/js/catalog.js']);
		return $this->render(['content' => $content]);
	}

	public function methodSearch($args)
	{
		if (empty($args['search'])) {
			return $this->methodIndex($args);
		}

		$sort = isset($args['sort']) ? $args['sort'] : '';
		$filters = isset($args['filters']) ? $args['filters'] : [];
		$catalogId = 0;

		$products = \App\Service\Product::filterBy($catalogId, $filters, $sort, [], ['~lang.name' => $args['search']]);

		$content = $this->view->render('templates/catalog/catalog_search.phtml', [

			'breadcrumbs' => $this->getBreadcrumbs($catalogId),
			'catalogs' => \Admin\Object\Catalog::where(['active' => 1])->getData(),
			'catalogId' => $catalogId,
			'filters' => \App\Service\Product::getAvailableFiltersDataForCatalog($catalogId, $products),
			'products' => $products['products']->getData(),
			'checked_filters' => $filters,
			'search' => $args['search'],
			'args' => $args,
			'sort' => $sort
		]);

		$this->addJavaScriptPath(['/js/catalog.js']);
		return $this->render(['content' => $content, 'search' => $args['search']]);
	}

	private function getBreadcrumbs($catalogId = null)
	{
		$data = [
			['url' => '/catalog/', 'name' => __('Catalog')]
		];

		if (!$catalogId) {
			array_push($data, ['name' => __('All')]);
		} else {
			$catalog = Orm::load('Catalog', $catalogId);

			if ($catalog->getValue('parent')) {
				$catalog2 = Orm::load('Catalog', $catalog->getValue('parent'));
				array_push($data, ['url' => '/catalog/view/' . $catalog2->getValue('url'), 'name' => $catalog2->getValue('name')]);
			}

			array_push($data, ['name' => $catalog->getValue('name')]);
		}

		return $this->renderBreadCrumbs($data);
	}
}
