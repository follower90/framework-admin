<?php

namespace App\Controller;

class Page extends Controller
{
	public function methodIndex($args)
	{
		$page = \Admin\Object\Page::findBy(['url' => $args['page']]);
		if (!$page) $this->render404();

		$data = [
			'page' => $page->getValues(),
			'breadcrumbs' => $this->renderBreadCrumbs([['name' => $page->getValue('name')]])
		];

		return $this->render([
			'content' => $this->view->render('templates/page.phtml', $data)
		]);
	}
}
