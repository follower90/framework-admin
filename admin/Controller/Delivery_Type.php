<?php

namespace Admin\Controller;

use Admin\Paging;
use Core\Orm;
use Core\Router;

class Delivery_Type extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Delivery_Type', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['types'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/delivery_type/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/delivery_type/add.phtml', []);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$data['page'] = Orm::load('Delivery_Type', $args['edit'])->getValues();
		$data['content'] = $this->view->render('templates/modules/delivery_type/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$type = Orm::load('Delivery_Type', $args['id']);
		} else {
			$type = Orm::create('Delivery_Type');
		}

		try {
			$type->updateAttributes($args);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($type->isNew()) {
				Router::redirect('/admin/delivery_type/new');
			}
		}

		Router::redirect('/admin/delivery_type/edit/' . $type->getId());
	}

	public function methodDuplicate($args)
	{
		$page = Orm::load('Delivery_Type', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$type = Orm::create('Delivery_Type');
		$type->updateAttributes($data);

		Router::redirect('/admin/delivery_type/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('Delivery_Type', $args['delete']);

		Orm::delete($page);
		$this->back();
	}
}
