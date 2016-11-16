<?php

namespace App\Services;

use \Core\Session;
use \Core\Orm;

class Cart
{
	public static function getCart()
	{
		if ($user = \Core\App::getUser()) {
			$cart = Orm::findBySql('Cart', 'select * from Cart where userId=? or session =?', [$user->getId(), Session::id()]);
		} else {
			$cart = Orm::find('Cart', ['session'], [Session::id()]);
		}

		return $cart;
	}

	public static function getCartCount()
	{
		$cart = static::getCart();
		$count = 0;

		foreach ($cart->getCollection() as $item) {
			$count += $item->getValue('count');
		}

		return $count;
	}

	public static function add($id, $count)
	{
		$cart = static::getCart();
		$existingProduct = $cart->stream()->filter(function ($o) use ($id) {
			return $o->getValue('productId') == $id;
		})->findFirst();

		if ($existingProduct) {
			$existingCount = $existingProduct->getValue('count');
			$existingProduct->setValue('count', $existingCount + $count);
			$existingProduct->save();
		} else {
			$product = Orm::create('Cart');
			$product->setValues([
				'userId' => \Core\App::getUser() ? \Core\App::getUser()->getId() : null,
				'session' => Session::id(),
				'productId' => $id,
				'count' => $count
			]);

			$product->save();
		}
	}

	public static function remove($id)
	{
		$cart = static::getCart();
		$product = $cart->stream()->filter(function ($o) use ($id) {
			return $o->getValue('id') == $id;
		})->findFirst();

		if ($product) {
			Orm::delete($product);
		}
	}
}
