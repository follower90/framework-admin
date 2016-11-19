<?php

namespace App\Api;

class Cart extends \Core\Api
{
	public function methodIndex()
	{
		$cart = \App\Services\Cart::getCart();
		return $cart->getData();
	}

	public function methodCount()
	{
		$count = \App\Services\Cart::getCartCount();
		return ['count' => $count];
	}

	public function methodUpdate($args)
	{
		if ($args['id']) {
			$item = \App\Services\Cart::find($args['id']);
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
			\App\Services\Cart::add($args['id'], $count);
		}

		return ['success' => true];
	}

	public function methodRemove($args)
	{
		if ($args['id']) {
			\App\Services\Cart::remove($args['id']);
		}

		return ['success' => true];
	}
}
