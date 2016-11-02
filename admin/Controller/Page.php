<?php

namespace Admin\Controller;

use \Core\View\Paging;
use \Core\Orm;
use \Core\Router;

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

		$data['content'] = $this->view->render('templates/pages/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew($args)
	{
		$data['form'] = $this->buildForm('page', [], [
			['field' => 'name', 'name' => 'Name', 'type' => 'input'],
			['field' => 'url', 'name' => 'Url', 'type' => 'input'],
			['field' => 'text', 'name' => 'Text', 'type' => 'textarea'],
		]);

		$data['content'] = $this->view->render('templates/pages/add.phtml', $data);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$data['page'] = Orm::load('Page', $args['edit'])->getValues();

		$data['form'] = $this->buildForm('page', $data['page'], [
			['field' => 'id', 'type' => 'hidden'],
			['field' => 'name', 'name' => 'Name', 'type' => 'input'],
			['field' => 'url', 'name' => 'Url', 'type' => 'input'],
			['field' => 'text', 'name' => 'Text', 'type' => 'textarea'],
		]);

		$data['content'] = $this->view->render('templates/pages/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{

		if (!empty($args['id'])) {
			$page = Orm::load('Page', $args['id']);
		} else {
			$page = Orm::create('Page');
		}

		$page->setValues($args);
		Orm::save($page);

		Router::redirect('/admin/page/edit/' . $page->getId());
	}

	public function methodDuplicate($args)
	{
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
		$page = Orm::load('Page', $args['delete']);

		Orm::delete($page);
		Router::redirect('/admin/page/');
	}
}
