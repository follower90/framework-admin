<?php

namespace App\Controller;

use Core\Orm;

class Index extends Controller
{
	public function methodIndex()
	{
		$page = \Admin\Object\Page::findBy(['url' => '/']);
		$data['controller'] = 'index';

		$data['content'] = $this->view->render('templates/index.phtml', [
			'page' => $page->getValues(),
			'slides' => Orm::find('Slider', ['active'], [1])->getData(),
			'latest' => \App\Service\Product::getByProductCategory('new_products', 4)->getData(),
			'featured' => \App\Service\Product::getByProductCategory('top_products', 4)->getData()
		]);

		return $this->render($data);
	}
}
