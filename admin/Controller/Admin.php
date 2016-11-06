<?php

namespace Admin\Controller;

use \Core\View\Paging;
use \Core\Orm;
use \Core\Router;

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
		$data['admins'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/admin/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['form'] = $this->buildForm('admin', [], [
			['field' => 'name', 'name' => 'Name', 'type' => 'input'],
			['field' => 'url', 'name' => 'Url', 'type' => 'input'],
			['field' => 'text', 'name' => 'Text', 'type' => 'textarea'],
		]);

		$data['content'] = $this->view->render('templates/admin/add.phtml', $data);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$admin = Orm::load('Admin', $args['edit']);
		$data['page'] = $admin->getValues();

		$data['form'] = $this->buildForm('admin', $data['page'], [
			['field' => 'id', 'type' => 'hidden'],
			['field' => 'name', 'name' => 'Name', 'type' => 'input'],
			['field' => 'login', 'name' => 'Login', 'type' => 'input'],
			['field' => '', 'name' => 'Password', 'type' => 'input']
		]);

		$data['content'] = $this->view->render('templates/admin/edit.phtml', $data);

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
