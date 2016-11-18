<?php

namespace App\Controller;

class Order extends Controller
{
	public function methodIndex()
	{
		$data = [];
		$orders = \Core\Orm::find('Order', ['userId'], [\Core\App::getUser()->getId()]);
		return $this->render($data);
	}
}

