<?php

namespace App\Controller;

class Order extends Controller
{
	public function methodIndex()
	{
		$data = [];
		$orders = \Core\Orm::find('Order', ['userId'], [\Core\App::getUser()->getId()])->getData();
		$data['content'] = $this->view->render('/templates/orders.phtml', ['orders' => $orders]);
		return $this->render($data);
	}
}

