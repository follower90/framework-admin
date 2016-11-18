<?php

namespace App\Controller;

use Core\Orm;

class Cart extends Controller
{
	public function methodIndex()
	{
		$cart = \App\Services\Cart::getCart()->getData();

		foreach($cart as &$c) {
			$c['product'] = \Core\Orm::load('Product', $c['productId'])->getValues();
		}

		$data['content'] = $this->view->render('templates/cart.phtml', ['cart' => $cart]);
		return $this->render($data);
	}

	public function methodRemove($args)
	{
		$item = \App\Services\Cart::find($args['id']);
		if ($item) Orm::delete($item);

		return $this->methodIndex();
	}
}
