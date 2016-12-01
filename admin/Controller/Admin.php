<?php

namespace Admin\Controller;

use Core\View\Paging;
use Core\Orm;
use Core\Router;

class Admin extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Admin', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['admins'] = $paging->getObjects(true);

		$data['content'] = $this->view->render('templates/modules/admin/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['groups'] = Orm::find('Admin_Group')->getHashMap('id', 'name');
		$data['content'] = $this->view->render('templates/modules/admin/add.phtml', $data);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$admin = Orm::load('Admin', $args['edit']);
		$data['content'] = $this->view->render('templates/modules/admin/edit.phtml', [
			'admin' => $admin->getValues(),
			'groups' => Orm::find('Admin_Group')->getHashMap('id', 'name')
		]);
		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$page = Orm::load('Admin', $args['id']);
		} else {
			$page = Orm::create('Admin');
		}

		$page->setValues($args);
		Orm::save($page);

		Router::redirect('/admin/admin/edit/' . $page->getId());
	}

	public function methodDuplicate($args)
	{
		$page = Orm::load('Admin', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('Admin');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/admin/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('Admin', $args['delete']);

		Orm::delete($page);
		Router::redirect('/admin/admin/');
	}
}
