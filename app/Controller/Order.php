<?php

namespace App\Controller;

use Core\Router;

class Order extends Controller
{
	public function methodIndex()
	{
		$data = [];

		if (!\Core\App::getUser()) {
			Router::redirect('/user/login');
		}

		$orders = \Core\Orm::find('Order', ['userId'], [\Core\App::getUser()->getId()])->getData();

		$breadcrumbs = $this->renderBreadCrumbs([['name' => __('Orders')]]);
		$data['content'] = $this->view->render('templates/user/orders.phtml', ['orders' => $orders, 'breadcrumbs' => $breadcrumbs]);
		return $this->render($data);
	}

	public function methodShow($args)
	{
		$order = \Core\Orm::findOne('Order', ['id', 'userId'], [$args['show'], $this->user->getId()]);
		$products = \Core\Orm::find('Order_Product', ['orderId'], [$order->getId()])->getData();

		foreach ($products as &$item) {
			if ($productExists = \Core\Orm::load('Product', $item['productId'])) {
				$item['photo_id'] = $productExists->getValues()['photo_id'];
				$item['url'] = $productExists->getValue('url');
			}
		}

		$data['content'] = $this->view->render('templates/user/order.phtml', [
			'order' => $order->getValues(),
			'products' => $products
		]);

		return $this->render($data);
	}
}

