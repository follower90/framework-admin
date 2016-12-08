<?php

namespace Admin\Controller;

use Core\View\Paging;
use Core\Orm;
use Core\Router;

class Page extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Page', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['pages'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/pages/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/pages/add.phtml', []);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$data['page'] = Orm::load('Page', $args['edit'])->getValues();
		$data['content'] = $this->view->render('templates/modules/pages/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		$this->checkWritePermissions();
		if (!empty($args['id'])) {
			$page = Orm::load('Page', $args['id']);
		} else {
			$page = Orm::create('Page');
		}

		$page->setValues($args);

		try {
			Orm::save($page);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($page->isNew()) {
				Router::redirect('/admin/page/new');
			}
		}

		Router::redirect('/admin/page/edit/' . $page->getId());
	}

	public function methodDuplicate($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('Page', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('Page');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/page/');
	}

	public function methodDelete($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('Page', $args['delete']);

		Orm::delete($page);
		Router::redirect('/admin/page/');
	}
}
