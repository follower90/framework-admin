<?php

namespace App\Controller;

class Product extends Controller
{
	public function methodIndex($args)
	{
		if (!$args['url'] || !$product = \Admin\Object\Product::findBy(['url' => $args['url']])) {
			$this->render404();
		}

		$data['product'] = $product->getValues();
		$data['product']['photo_id'] = $product->getPhotoResourceId();

		return $this->render([
			'content' => $this->view->render('templates/product_in.phtml', $data)
		]);
	}
}
