<?php

namespace Admin\Controller;

use Admin\Paging;
use Core\Orm;
use Core\Router;

class Product_Category extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('ProductCategory', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['categories'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/product_category/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/product_category/add.phtml', []);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$data['page'] = Orm::load('ProductCategory', $args['edit'])->getValues();
		$data['content'] = $this->view->render('templates/modules/product_category/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$template = Orm::load('ProductCategory', $args['id']);
		} else {
			$template = Orm::create('ProductCategory');
		}

		$args['body'] = addslashes($args['body']);

		try {
			$template->updateAttributes($args);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($template->isNew()) {
				Router::redirect('/admin/product_category/new');
			}
		}

		Router::redirect('/admin/product_category/edit/' . $template->getId());
	}

	public function methodDuplicate($args)
	{
		$page = Orm::load('ProductCategory', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$category = Orm::create('ProductCategory');
		$category->updateAttributes($data);

		Router::redirect('/admin/product_category/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('ProductCategory', $args['delete']);

		Orm::delete($page);
		$this->back();
	}
}
