<?php

namespace App\Controller;

class Catalog extends Controller
{
	public function methodIndex($args)
	{
		if (!$args['url'] || $args['url'] === 'all') {
			$content = $this->view->render('templates/catalog_list.phtml', [
				'catalogs' => \Admin\Object\Catalog::where(['active' => 1])->getData()
			]);
		} else {
			$catalog = \Admin\Object\Catalog::findBy(['url' => $args['url']]);
			if (!$catalog) $this->render404();

			$content = $this->view->render('templates/catalog.phtml', [
				'catalog' => $catalog->getValues(),
				'products' => $catalog->getRelated('products')->getData()
			]);
		}

		return $this->render(['content' => $content]);
	}
}
