<?php

namespace App\Controller;

class Product extends Controller
{
	public function methodIndex($args)
	{
		if (!$args['url']) $this->render404();
		$product = \Admin\Object\Product::findBy(['url' => $args['url']]);
		if (!$product) $this->render404();

		$content = $this->view->render('templates/product_in.phtml', [
			'product' => $product->getValues()
		]);

		return $this->render(['content' => $content]);
	}
}
