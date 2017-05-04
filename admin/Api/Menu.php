<?php

namespace Admin\Api;

use Core\Orm;

class Menu extends \Core\Api
{
	public function methodIndex($args)
	{
		header("Access-Control-Allow-Origin: *");
		$items = Orm::find('Menu');
		$result = [];
		$items->stream()->each(function($item) use (&$result) {
			$result[]= $item->getValues();
		});

		return $result;
	}

	public function methodGet($args)
	{
		header("Access-Control-Allow-Origin: *");

		if (!$args['id']) return false;
		$page = Orm::load('Menu', $args['id']);

		return $page->getValues();
	}

	public function methodActive($args)
	{
		if (!$args['id']) return false;
		$page = Orm::load('Menu', $args['id']);
		$page->setValue('active', (int)$args['active']);
		Orm::save($page);

		return ['success' => true];
	}

	public function methodSort($args)
	{
		$order = $args['ids'];
		$max = count($args['ids']);

		foreach ($order as $id) {
			$menuItem = Orm::load('Menu', $id);
			$menuItem->setValue('sort', --$max);
			$menuItem->save();
		}

		return ['success' => true];
	}

}
