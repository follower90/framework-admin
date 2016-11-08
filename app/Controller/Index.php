<?php

namespace App\Controller;

class Index extends Controller
{
	public function methodIndex()
	{
		$page = \Admin\Object\Page::findBy(['url' => '/']);
		$data['content'] = $this->view->render('templates/index.phtml', ['page' => $page->getValues()]);
		return $this->render($data);
	}
}
