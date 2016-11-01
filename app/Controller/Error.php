<?php

namespace App\Controller;

class Error extends Controller
{
	public function methodIndex($args)
	{
		header("HTTP/1.0 404 Not Found");
		return $this->view->render('templates/404.phtml', []);
	}
}
