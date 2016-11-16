<?php

namespace App\Controller;

class Cart extends Controller
{
	public function methodIndex()
	{
		$cart = \App\Services\Cart::getCart();

		$data['content'] = $this->view->render('templates/cart.phtml', ['cart' => $cart->getData()]);
		return $this->render($data);
	}
}
