<?php

namespace Admin\Controller;

use Core\View\Paging;
use Core\Orm;
use Core\Router;

class Meta extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Meta', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['meta'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/meta/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/meta/add.phtml');
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$meta = Orm::load('Meta', $args['edit'])->getValues();
		$data['content'] = $this->view->render('templates/modules/meta/edit.phtml', ['meta' => $meta]);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		$this->checkWritePermissions();
		if (!empty($args['id'])) {
			$meta = Orm::load('Meta', $args['id']);
		} else {
			$meta = Orm::create('Meta');
		}

		$meta->setValues($args);

		try {
			Orm::save($meta);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($meta->isNew()) {
				Router::redirect('/admin/meta/new');
			}
		}
		Router::redirect('/admin/meta/edit/' . $meta->getId());
	}

	public function methodDuplicate($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('Meta', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('Meta');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/meta/');
	}

	public function methodDelete($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('Meta', $args['delete']);

		Orm::delete($page);
		Router::redirect('/admin/meta/');
	}
}
