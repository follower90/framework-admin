<?php

namespace App\Controller;

use Core\Router;

class Catalog extends Controller
{
	public function methodIndex($args)
	{
		if (!$args['url']) {
			Router::redirect('/catalog/all', Router::HEADER_MOVED_PERMANENTLY);
		}

		if ($args['url'] === 'all') {
			$catalogs = ['catalog1', 'catalog2', 'catalog3'];
			return $this->view->render('templates/catalog_list.phtml', ['catalogs' => $catalogs]);
		} else {
			return $this->view->render('templates/catalog.phtml', ['name' => mb_strtoupper($args['url'])]);
		}

	}
}
