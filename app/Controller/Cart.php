<?php

namespace App\Controller;

use Core\Orm;
use Core\Router;

use App\Service\Cart as CartService;

class Cart extends Controller
{
	public function methodIndex()
	{
		$vars = [
			'cart' => CartService::getCart()->getData(),
			'total' => CartService::getTotal(),
			'userinfo' => $this->user ? $this->user->getInfo() : [],
			'breadcrumbs' => $this->renderBreadCrumbs([['name' => __('Cart')]])
		];

		if (CartService::getCartCount() == 0) {
			$data = ['content' => $this->view->render('templates/cart_empty.phtml', $vars)];
		} else {

			$vars['delivery_types'] = Orm::find('Delivery_Type')->getData();
			$vars['payment_types'] = Orm::find('Payment_Type')->getData();

			$data = ['content' => $this->view->render('templates/cart.phtml', $vars)];
		}

		return $this->render($data);
	}

	public function methodRemove($args)
	{
		$item = CartService::find($args['remove']);
		if ($item) Orm::delete($item);

		Router::redirect('/cart');
	}

	public function methodRecalculate($args)
	{
		$i = 0;
		foreach ($args['id'] as $id) {
			CartService::update($id, $args['count'][$i++]);
		}

		Router::redirect('/cart');
	}

	public function methodOrder($args)
	{
		$order = Orm::create('Order');

		$order->setValues([
			'userId' => $this->user ? $this->user->getId() : null,
			'sum' => CartService::getTotal(),
			'firstName' => $args['firstName'],
			'lastName' => $args['lastName'],
			'email' => $args['email'],
			'phone' => $args['phone'],
			'city' => $args['city'],
			'address' => $args['address'],
			'payment' => Orm::load('Payment_Type', $args['payment'])->getValue('name'),
			'delivery' => Orm::load('Delivery_Type', $args['delivery'])->getValue('name'),
			'comment' => $args['comment']
		]);

		$order->save();

		$cart = CartService::getCart()->getCollection();

		foreach($cart as $c) {
			$product = Orm::load('Product', $c->getValue('productId'));

			$orderedProduct = \Core\Orm::create('Order_Product');
			$orderedProduct->setValues([
				'orderId' => $order->getId(),
				'productId' => $product->getId(),
				'name' => $product->getValue('name'),
				'price' => $product->getValue('price'),
				'count' => $c->getValue('count')
			]);

			$orderedProduct->save();
		}

		$name = $args['firstName'] .' '. $args['lastName'];

		CartService::sendOrderEmailToUser($order, $args['email'], $name);
		CartService::clear();

		Router::redirect('/cart/ordersent');
	}

	public function methodOrderSent()
	{
		$info = \Admin\Object\InfoBlock::get('order_sent')->getValues();
		return $this->render(['content' => $this->view->render('templates/page.phtml', $info)]);
	}
}
