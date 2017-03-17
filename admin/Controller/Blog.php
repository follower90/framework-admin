<?php

namespace Admin\Controller;

use Admin\Paging;
use Core\Orm;
use Core\Router;

class Blog extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Blog', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['pages'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/blog/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/blog/add.phtml', []);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$data['page'] = Orm::load('Blog', $args['edit'])->getValues();
		$data['content'] = $this->view->render('templates/modules/blog/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$page = Orm::load('Blog', $args['id']);
		} else {
			$page = Orm::create('Blog');
		}

		if (empty($args['url'])) {
			$args['url'] = \Core\Library\String::translit($args['name']);
		}

		try {
			$page->updateAttributes($args);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($page->isNew()) {
				Router::redirect('/admin/blog/new');
			}
		}

		Router::redirect('/admin/blog/edit/' . $page->getId());
	}

	public function methodDuplicate($args)
	{
		$page = Orm::load('Blog', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('Blog');
		$newPage->updateAttributes($data);

		Router::redirect('/admin/blog/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('Blog', $args['delete']);

		Orm::delete($page);
		$this->back();
	}
}
