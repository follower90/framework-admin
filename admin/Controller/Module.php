<?php

namespace Admin\Controller;

use Admin\Paging;
use Core\Orm;
use Core\Router;

class Module extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Module', [
			'page_size' => 20,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['modules'] = $paging->getObjects(true);

		$data['content'] = $this->view->render('templates/modules/module/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$types = \Admin\Object\Module::getTypesMap();
		$data['content'] = $this->view->render('templates/modules/module/add.phtml', ['types' => $types]);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$data['types'] = \Admin\Object\Module::getTypesMap();
		$data['module'] = Orm::load('Module', $args['edit'])->getValues();
		$data['content'] = $this->view->render('templates/modules/module/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		$this->checkWritePermissions();
		if (!empty($args['id'])) {
			$page = Orm::load('Module', $args['id']);
		} else {
			$page = Orm::create('Module');
		}

		$page->setValues($args);

		try {
			Orm::save($page);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($page->isNew()) {
				Router::redirect('/admin/module/new');
			}
		}

		Router::redirect('/admin/module/edit/' . $page->getId());
	}

	public function methodDuplicate($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('Module', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('Module');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/module/');
	}

	public function methodDelete($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('Module', $args['delete']);

		Orm::delete($page);
		$this->back();
	}
}
