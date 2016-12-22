<?php

namespace Admin\Controller;

use Core\View\Paging;
use Core\Orm;
use Core\Router;

class Payment_Type extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Payment_Type', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['types'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/payment_type/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/payment_type/add.phtml', []);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$data['page'] = Orm::load('Payment_Type', $args['edit'])->getValues();
		$data['content'] = $this->view->render('templates/modules/payment_type/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		$this->checkWritePermissions();
		if (!empty($args['id'])) {
			$page = Orm::load('Payment_Type', $args['id']);
		} else {
			$page = Orm::create('Payment_Type');
		}

		$page->setValues($args);

		try {
			Orm::save($page);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($page->isNew()) {
				Router::redirect('/admin/payment_type/new');
			}
		}

		Router::redirect('/admin/payment_type/edit/' . $page->getId());
	}

	public function methodDuplicate($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('Payment_Type', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('Payment_Type');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/payment_type/');
	}

	public function methodDelete($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('Payment_Type', $args['delete']);

		Orm::delete($page);
		$this->back();
	}
}
