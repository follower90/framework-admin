<?php

namespace App\Controller;

class Order extends Controller
{
	public function methodIndex()
	{
		$data = [];
		$orders = \Core\Orm::find('Order', ['userId'], [\Core\App::getUser()->getId()])->getData();

		$data['breadcrumbs'] = $this->renderBreadCrumbs([['name' => i18n('Orders')]]);
		$data['content'] = $this->view->render('/templates/orders.phtml', ['orders' => $orders]);
		return $this->render($data);
	}

	public function methodShow($args)
	{
		$order = \Core\Orm::findOne('Order', ['id', 'userId'], [$args['show'], $this->user->getId()]);
		$products = \Core\Orm::find('Order_Product', ['orderId'], [$order->getId()])->getData();

		foreach ($products as &$item) {
			if ($productExists = \Core\Orm::load('Product', $item['productId'])) {
				$item['photo_id'] = $productExists->getPhotoResourceId();
			}
		}

		$data['content'] = $this->view->render('/templates/order.phtml', [
			'order' => $order->getValues(),
			'products' => $products
		]);

		return $this->render($data);
	}
}

