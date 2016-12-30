<?php

namespace App\Api;

class Favourite extends \Core\Api
{
	public function methodAdd($args)
	{
		if ($args['id']) {
			\App\Service\Favourite::add($args['entity'], $args['id']);
		}

		return ['success' => true];
	}

	public function methodRemove($args)
	{
		if ($args['id']) {
			\App\Service\Favourite::remove($args['entity'], $args['id']);
		}

		return ['success' => true];
	}

	public function methodList($args)
	{
		$view = new \Core\View();
		$view->setDefaultPath('public/fashion');

		$products = \Core\Orm::find(ucfirst($args['entity']), ['id'], [\App\Service\Favourite::getList($args['entity'])->getValues('entityId')]);
		return $view->render('templates/favourites/products.phtml', ['products' => $products->getData()]);
	}
}
