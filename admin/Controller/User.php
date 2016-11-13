<?php

namespace Admin\Controller;

use \Core\View\Paging;
use \Core\Orm;
use \Core\Router;

class User extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('User', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['users'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/user/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/user/add.phtml', []);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$data['user'] = Orm::load('User', $args['edit'])->getValues();
		$data['content'] = $this->view->render('templates/modules/user/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$user = Orm::load('User', $args['id']);
		} else {
			$user = Orm::create('User');
		}

		$user->setValues($args);

		try {
			Orm::save($user);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($user->isNew()) {
				Router::redirect('/admin/user/new');
			}
		}

		Router::redirect('/admin/user/edit/' . $user->getId());
	}

	public function methodDuplicate($args)
	{
		$page = Orm::load('User', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('User');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/user/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('User', $args['delete']);

		Orm::delete($page);
		Router::redirect('/admin/user/');
	}
}
