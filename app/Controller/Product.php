<?php

namespace App\Controller;

class Product extends Controller
{
	public function methodIndex($args)
	{
		if (!$args['url'] || !$product = \Admin\Object\Product::findBy(['url' => $args['url']])) {
			$this->render404();
		}

		return $this->render([
			'content' => $this->view->render('templates/product_in.phtml', ['product' => $product->getValues()])
		]);
	}
}
