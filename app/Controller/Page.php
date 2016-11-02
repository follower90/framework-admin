<?php

namespace App\Controller;

use Core\Router;

class Page extends Controller
{
	public function methodIndex($args)
	{
		$page = \Admin\Object\Page::findBy(['url' => $args['page']]);
		if (!$page) {
			Router::redirect('404', Router::NOT_FOUND_404);
		}

		return $this->renderPage('templates/page.phtml', $page->getValues());
	}
}

