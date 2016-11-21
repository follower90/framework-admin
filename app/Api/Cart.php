<?php

namespace App\Api;

class Cart extends \Core\Api
{
	public function methodIndex()
	{
		$cart = \App\Service\Cart::getCart();
		return $cart->getData();
	}

	public function methodCount()
	{
		$count = \App\Service\Cart::getCartCount();
		return ['count' => $count];
	}

	public function methodUpdate($args)
	{
		if ($args['id']) {
			$item = \App\Service\Cart::find($args['id']);
			if ($item) {
				$item->setValue('count', $args['count']);
				$item->save();

				return ['success' => true];
			}
		}

		return ['error' => ''];
	}

	public function methodAdd($args)
	{
		if ($args['id']) {
			$count = isset($args['count']) ? $args['count'] : 1;
			\App\Service\Cart::add($args['id'], $count);
		}

		return ['success' => true];
	}

	public function methodRemove($args)
	{
		if ($args['id']) {
			\App\Service\Cart::remove($args['id']);
		}

		return ['success' => true];
	}
}
