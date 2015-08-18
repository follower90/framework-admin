<?php

namespace Admin\Controller;

use \Admin\Paging;
use \Core\Orm;
use \Core\Router;

class Page extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Page', [
			'page_size' => 1,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['pages'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/pages/index.phtml', $data);

		return $this->render($data);
	}

	public function methodAdd($args)
	{
		$data['content'] = $this->view->render('templates/pages/add.phtml', []);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$data['page'] = Orm::load('Page', $args['id'])->getValues();
		$data['content'] = $this->view->render('templates/pages/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$page = Orm::load('Page', $args['id']);
		} else {
			$page = Orm::create('Page');
		}

		$page->setValues($args);
		Orm::save($page);

		Router::redirect('/admin/page/edit?id=' . $page->getId());
	}

	public function methodDelete($args)
	{
		$page = Orm::load('Page', $args['id']);

		Orm::delete($page);
		Router::redirect('/admin/page/');
	}
}
