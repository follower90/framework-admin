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

	public static function getTotal()
	{
		$cart = static::getCart()->getCollection();
		$total = 0;

		foreach ($cart as $item) {
			$product = Orm::load('Product', $item->getValue('productId'));
			$total += $item->getValue('count') * $product->getValue('price');
		}

		return $total;
	}

	public static function find($id)
	{
		if ($user = \Core\App::getUser()) {
			return Orm::findBySql('Cart', 'select * from Cart where (userId=? or session =?) and id=?', [$user->getId(), Session::id(), $id])->getFirst();
		} else {
			return Orm::findOne('Cart', ['session', 'id'], [Session::id(), $id]);
		}
	}

	public static function update($id, $count)
	{
		if ($count < 0) return;
		if ($user = \Core\App::getUser()) {
			$item = Orm::findBySql('Cart', 'select * from Cart where (userId=? or session =?) and id=?', [$user->getId(), Session::id(), $id])->getFirst();
		} else {
			$item = Orm::findOne('Cart', ['session', 'id'], [Session::id(), $id]);
		}

		if ($item->getValue('count') != $count) {
			$item->setValue('count', (int) $count);
			$item->save();
		}
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

	public static function clear()
	{
		foreach (static::getCart()->getCollection() as $item) {
			Orm::delete($item);
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
