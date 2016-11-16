<?php

namespace App\Controller;

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
}
