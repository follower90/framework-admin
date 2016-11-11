<?php

namespace Admin\Controller;

use \Core\View\Paging;
use \Core\Orm;
use \Core\Router;

class Product extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Product', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : $args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['products'] = $paging->getObjects(true);

		$data['content'] = $this->view->render('templates/modules/product/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$vars['catalogs'] = Orm::find('Catalog', ['active'], [1])->getHashMap('id', 'name');
		$data['content'] = $this->view->render('templates/modules/product/add.phtml', $vars);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$product = Orm::load('Product', $args['edit']);
		$data['product'] = $product->getValues();
		$data['product']['catalog_id'] = $product->getCatalogId();
		$data['catalogs'] = Orm::find('Catalog', ['active'], [1])->getHashMap('id', 'name');

		$data['content'] = $this->view->render('templates/modules/product/edit.phtml', $data);
		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$product = Orm::load('Product', $args['id']);
		} else {
			$product = Orm::create('Product');
		}

		$product->setValues($args);
		$product->setCatalog($args['catalog_id']);

		try {
			Orm::save($product);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($product->isNew()) {
				Router::redirect('/admin/product/new');
			}
		}

		Router::redirect('/admin/product/edit/' . $product->getId());
	}

	public function methodDuplicate($args)
	{
		$product = Orm::load('Product', $args['duplicate']);
		$data = $product->getValues();
		unset($data['id']);

		$newProduct = Orm::create('product');
		$newProduct->setValues($data);
		Orm::save($newProduct);

		Router::redirect('/admin/product/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('Product', $args['delete']);

		Orm::delete($page);
		Router::redirect('/admin/product/');
	}
}
