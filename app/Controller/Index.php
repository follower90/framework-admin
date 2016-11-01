<?php

namespace App\Controller;

class Index extends Controller
{
	public function methodIndex($args)
	{
		$data['content'] = $this->view->render('templates/index.phtml', $args);
		return $this->render($data);
	}
}
