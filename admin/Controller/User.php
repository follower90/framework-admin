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
		$user = Orm::load('User', $args['edit']);

		$data['user'] = $user->getValues();
		$data['user']['info'] = Orm::findOne('User_Info', ['userId'], [$user->getId()])->getValues();

		$data['content'] = $this->view->render('templates/modules/user/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$user = Orm::load('User', $args['id']);
			$info = Orm::findOne('User_Info', ['userId'], [$user->getId()]);
		} else {
			$user = Orm::create('User');
			$info = Orm::create('User_Info');
		}

		$password = trim($args['password']);
		if ($password) {
			$user->setValue('password', md5($password));
		}

		unset($args['password']);
		$user->setValues($args);

		try {
			Orm::save($user);
			$info->setValues($args['info']);
			$info->setValue('userId', $user->getId());
			$info->save();
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
		$user = Orm::load('User', $args['delete']);
		$userInfo = Orm::findOne('User_Info', ['userId'], [$args['delete']]);

		Orm::delete($user);
		Orm::delete($userInfo);

		Router::redirect('/admin/user/');
	}
}
