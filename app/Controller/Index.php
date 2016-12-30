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
			'latest' => Orm::find('Product', ['active'], [1], ['limit' => 4])->getData(),
			'featured' => Orm::find('Product', ['active'], [1], ['limit' => 4])->getData()
		]);

		return $this->render($data);
	}
}
