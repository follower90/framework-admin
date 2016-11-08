<?php

namespace App\Controller;

class Page extends Controller
{
	public function methodIndex($args)
	{
		$page = \Admin\Object\Page::findBy(['url' => $args['page']]);
		if (!$page) $this->render404();

		return $this->render([
			'content' => $this->view->render('templates/page.phtml', $page->getValues())
		]);
	}
}
