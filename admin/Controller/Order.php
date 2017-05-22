<?php

namespace Admin\Controller;

use Admin\Paging;
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
		$data['statuses'] = \Admin\Object\Order::getStatusMap();
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

		try {
			$order->updateAttributes($args);
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

		$order = Orm::create('Order');
		$order->updateAttributes($data);

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
		$this->back();
	}
}
