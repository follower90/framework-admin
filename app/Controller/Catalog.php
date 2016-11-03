<?php

namespace App\Controller;

use Core\Router;

class Catalog extends Controller
{
	public function methodIndex($args)
	{
		if (!$args['url']) Router::redirect('/catalog/all', Router::HEADER_MOVED_PERMANENTLY);

		if ($args['url'] === 'all') {
			$catalogs = \Admin\Object\Catalog::where(['active' => 1])->getData();
			return $this->view->render('templates/catalog_list.phtml', ['catalogs' => $catalogs]);
		} else {
			$catalog = \Admin\Object\Catalog::findBy(['url' => $args['url']]);
			//if (!$catalog) $this->render404();
			return $this->view->render('templates/catalog.phtml', $catalog->getValues());
		}
	}
}
