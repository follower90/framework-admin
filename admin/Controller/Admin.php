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
		$this->checkWritePermissions();

		if (!empty($args['id'])) {
			$admin = Orm::load('Admin', $args['id']);
		} else {
			$admin = Orm::create('Admin');
		}

		$password = trim($args['password']);
		if ($password) {
			$admin->setValue('password', \Admin\Object\Admin::hashPassword($password));
		}

		unset($args['password']);
		$admin->setValues($args);

		Orm::save($admin);

		Router::redirect('/admin/admin/edit/' . $admin->getId());
	}

	public function methodDuplicate($args)
	{
		$this->checkWritePermissions();
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
		$this->checkWritePermissions();
		$page = Orm::load('Admin', $args['delete']);

		Orm::delete($page);
		$this->back();
	}
}
