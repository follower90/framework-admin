<?php

namespace App\Service;

use \Core\Session;
use \Core\Orm;

class Favourite
{
	public static function getList($entity)
	{
		if ($user = \Core\App::getUser()) {
			$cart = Orm::findBySql('Favourite', 'select * from Favourite where entity=? and (userId=? or session =?)', [$entity, $user->getId(), Session::id()]);
		} else {
			$cart = Orm::find('Favourite', ['entity', 'session'], [$entity, Session::id()]);
		}

		return $cart;
	}

	public static function add($entity, $id)
	{
		$favourites = static::getList($entity);
		$existingItem = $favourites->stream()->filter(function ($o) use ($id) {
			return $o->getValue('entityId') == $id;
		})->findFirst();

		if (!$existingItem) {
			$fav = Orm::create('Favourite');
			$fav->setValues([
				'userId' => \Core\App::getUser() ? \Core\App::getUser()->getId() : null,
				'session' => Session::id(),
				'entityId' => $id,
				'entity' => $entity
			]);

			$fav->save();
		}
	}

	public static function remove($entity, $id)
	{
		$favourites = static::getList($entity);
		$item = $favourites->stream()->filter(function ($o) use ($id) {
			return $o->getValue('entityId') == $id;
		})->findFirst();

		if ($item) {
			Orm::delete($item);
		}
	}
}
