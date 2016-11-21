<?php

namespace App\Controller;

use Core\Orm;

class Cart extends Controller
{
	public function methodIndex()
	{
		if (\App\Service\Cart::getCartCount() == 0) {
			$data['content'] = $this->view->render('templates/cart_empty.phtml');
			return $this->render($data);
		}

		$cart = \App\Services\Cart::getCart()->getData();

		$data = [
			'cart' => $cart,
			'total' => \App\Services\Cart::getTotal(),
			'userinfo' => $this->user ? Orm::findOne('User_Info', ['userId'], $this->user->getId())->getValues() : []
		];

		$data['content'] = $this->view->render('templates/cart.phtml', $data);
		return $this->render($data);
	}

	public function methodRemove($args)
	{
		$item = \App\Service\Cart::find($args['remove']);
		if ($item) Orm::delete($item);

		return $this->methodIndex();
	}

	public function methodRecalculate($args)
	{
		$i = 0;
		foreach ($args['id'] as $id) {
			\App\Service\Cart::update($id, $args['count'][$i]);
		}
		return $this->methodIndex();
	}

	public function methodOrder($args)
	{
		$order = \Core\Orm::create('Order');

		$order->setValues([
			'userId' => $this->user ? $this->user->getId() : null,
			'sum' => \App\Services\Cart::getTotal(),
			'firstName' => $args['firstName'],
			'lastName' => $args['lastName'],
			'phone' => $args['phone'],
			'address' => $args['address'],
			'comment' => $args['comment']
		]);

		$order->save();

		$cart = \App\Service\Cart::getCart()->getCollection();

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

		\App\Service\Cart::clear();
		return $this->methodIndex();
	}
}
