<?php

namespace Admin\Controller;

use Core\View\Paging;
use Core\Orm;
use Core\Router;

class Order extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Order', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['orders'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/order/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/order/add.phtml', []);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$order = Orm::load('Order', $args['edit']);
		$data['order'] = $order->getValues();
		$data['products'] = Orm::find('Order_Product', ['orderId'], [$order->getId()])->getData();

		$data['content'] = $this->view->render('templates/modules/order/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$order = Orm::load('Order', $args['id']);
		} else {
			$order = Orm::create('Order');
		}

		$order->setValues($args);

		try {
			Orm::save($order);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($order->isNew()) {
				Router::redirect('/admin/order/new');
			}
		}

		Router::redirect('/admin/order/edit/' . $order->getId());
	}

	public function methodDuplicate($args)
	{
		$page = Orm::load('Order', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('Order');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/user/');
	}

	public function methodDelete($args)
	{
		$order = Orm::load('Order', $args['delete']);
		$orderProducts = Orm::find('Order_Product', ['orderId'], [$args['delete']])->getCollection();

		foreach ($orderProducts as $product) {
			Orm::delete($product);
		}

		Orm::delete($order);
		Router::redirect('/admin/order/');
	}
}
