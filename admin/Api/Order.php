<?php

namespace Admin\Api;

use \Core\Orm;

class Order extends \Core\Api
{
	public function methodAddProduct($args)
	{
		$order = Orm::load('Order', $args['orderId']);
		$product = Orm::load('Product', $args['productId']);

		$orderedProduct = Orm::create('Order_Product');
		$orderedProduct->setValues([
			'orderId' => $order->getId(),
			'productId' => $product->getId(),
			'name' => $product->getValue('name'),
			'price' => $product->getValue('price'),
			'count' => 1
		]);

		$orderedProduct->save();

		$order = Orm::load('Order', $args['orderId']);
		$order->updateAttributes(['sum' => $order->calculateSum()]);

		return true;
	}

	public function methodRemoveProduct($args)
	{
		$orderedProduct = Orm::load('Order_Product', $args['productId']);
		$orderedProduct->delete();

		$order = Orm::load('Order', $args['orderId']);
		$order->updateAttributes(['sum' => $order->calculateSum()]);

		return true;
	}
}