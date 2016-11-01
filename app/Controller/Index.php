<?php

namespace App\Controller;

class Index extends Controller
{
	public function methodIndex($args)
	{
		$obj = \App\Object\Test::find(1);
		var_dump($obj);
		$data['content'] = $this->view->render('templates/index.phtml', $args);
		return $this->render($data);
	}
}
