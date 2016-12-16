<?php

namespace App\Controller;

use Core\Orm;

class Product extends Controller
{
	public function methodIndex($args)
	{
		if (!$args['url'] || !$product = \Admin\Object\Product::findBy(['url' => $args['url']])) {
			$this->render404();
		}

		$data = [
			'product' => $product->getValues(),
			'userinfo' => $this->user ? Orm::findOne('User_Info', ['userId'], $this->user->getId())->getValues() : [],
			'delivery_types' =>Orm::find('Delivery_Type')->getData(),
			'payment_types' =>  Orm::find('Payment_Type')->getData()
		];

		return $this->render([
			'content' => $this->view->render('templates/product_in.phtml', $data)
		]);
	}

	public function methodOrder($args)
	{
		$order = Orm::create('Order');
		$product = Orm::load('Product', $args['id']);

		$order->setValues([
			'userId' => $this->user ? $this->user->getId() : null,
			'sum' => $product->getValue('price'),
			'firstName' => $args['firstName'],
			'lastName' => $args['lastName'],
			'email' => $args['email'],
			'phone' => $args['phone'],
			'address' => $args['address'],
			'payment' => Orm::load('Payment_Type', $args['payment'])->getValue('name'),
			'delivery' => Orm::load('Delivery_Type', $args['delivery'])->getValue('name'),
			'comment' => $args['comment']
		]);

		$order->save();

		$orderedProduct = \Core\Orm::create('Order_Product');
		$orderedProduct->setValues([
			'orderId' => $order->getId(),
			'productId' => $product->getId(),
			'name' => $product->getValue('name'),
			'price' => $product->getValue('price'),
			'count' => 1
		]);

		$orderedProduct->save();

		$siteName = \Admin\Object\Setting::get('sitename');

		$mailTemplate = \Admin\Object\MailTemplate::get('new_order');
		$body = $this->view->renderInlineTemplate(
			$mailTemplate->getValue('body'),
			[
				'products' => Orm::find('Order_Product',['orderId'],[$order->getId()])->getData(),
				'order' => $order->getValues(),
				'site' => $siteName,
				'name' => $args['firstName'] .' '. $args['lastName'],
			]
		);

		\App\Service\Mail::send($args['email'], $siteName .' - ' . $mailTemplate->getValue('subject'), $body);
		\Core\Router::redirect('/cart/ordersent');
	}
}
