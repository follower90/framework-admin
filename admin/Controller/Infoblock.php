<?php

namespace Admin\Controller;

use Core\View\Paging;
use Core\Orm;
use Core\Router;

class Infoblock extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('InfoBlock', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['pages'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/infoblock/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/infoblock/add.phtml', []);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$data['page'] = Orm::load('InfoBlock', $args['edit'])->getValues();
		$data['content'] = $this->view->render('templates/modules/infoblock/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$page = Orm::load('InfoBlock', $args['id']);
		} else {
			$page = Orm::create('InfoBlock');
		}

		$page->setValues($args);

		try {
			Orm::save($page);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($page->isNew()) {
				Router::redirect('/admin/infoblock/new');
			}
		}

		Router::redirect('/admin/infoblock/edit/' . $page->getId());
	}

	public function methodDuplicate($args)
	{
		$page = Orm::load('InfoBlock', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('InfoBlock');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/infoblock/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('InfoBlock', $args['delete']);

		Orm::delete($page);
		Router::redirect('/admin/infoblock/');
	}
}
