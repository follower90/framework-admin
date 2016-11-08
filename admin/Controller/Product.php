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
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['products'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/product/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['form'] = $this->buildForm('product', [], [
			['field' => 'name', 'name' => 'Name', 'type' => 'input'],
			['field' => 'url', 'name' => 'Url', 'type' => 'input'],
			['field' => 'text', 'name' => 'Text', 'type' => 'texteditor'],
		]);

		$data['content'] = $this->view->render('templates/modules/product/add.phtml', $data);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$product = Orm::load('Product', $args['edit']);
		$data['product'] = $product->getValues();
		$data['product']['catalog_id'] = $product->getCatalogId();

		$catalogMap = Orm::find('Catalog', ['active'], [1])->getHashMap('id', 'name');

		$data['form'] = $this->buildForm('product', $data['product'], [
			['field' => 'id', 'type' => 'hidden'],
			['field' => 'name', 'name' => 'Name', 'type' => 'input'],
			['field' => 'catalog_id', 'name' => 'Catalog', 'type' => 'select', 'options' => $catalogMap],
			['field' => 'url', 'name' => 'Url', 'type' => 'input'],
			['field' => 'text', 'name' => 'Text', 'type' => 'texteditor'],
		]);

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
		$page = Orm::load('Product', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('product');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/product/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('Product', $args['delete']);

		Orm::delete($page);
		Router::redirect('/admin/product/');
	}
}
