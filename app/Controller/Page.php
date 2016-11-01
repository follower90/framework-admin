<?php

namespace App\Controller;

use Core\Router;

class Page extends Controller
{
	public function methodIndex($args)
	{
		$page = \Admin\Object\Page::findBy(['url' => $args['url'][0]]);
		if (!$page) Router::redirect('404', Router::NOT_FOUND_404);

		return $this->renderPage('templates/index.phtml', $page->getValues());
	}
}
