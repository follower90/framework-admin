<?php

namespace App\Controller;

class Catalog extends Controller
{
	public function methodIndex($args)
	{
		if (!$args['url'] || $args['url'] === 'all') {
			$products = \Admin\Object\Product::where(['active' => 1])->getCollection();
			$productsData = [];

			foreach ($products as $product) {
				$productsData[$product->getId()] = $product->getInfo();
			}

			$content = $this->view->render('templates/catalog_list.phtml', [
				'catalogs' => \Admin\Object\Catalog::where(['active' => 1])->getData(),
				'products' => $productsData
			]);

		} else {
			$catalog = \Admin\Object\Catalog::findBy(['url' => $args['url']]);
			if (!$catalog) $this->render404();

			$products = $catalog->getRelated('products')->getCollection();

			$productsData = [];
			foreach ($products as $product) {
				$productsData[] = $product->getInfo();
			}

			$content = $this->view->render('templates/catalog_list.phtml', [
				'catalogs' => \Admin\Object\Catalog::where(['active' => 1])->getData(),
				'catalog' => $catalog->getId(),
				'products' => $productsData
			]);
		}

		return $this->render(['content' => $content]);
	}
}
