<?php

namespace App\Controller;

class Error extends Controller
{
	public function methodIndex()
	{
		header("HTTP/1.0 404 Not Found");
		return $this->render(['content' => $this->view->render('templates/404.phtml')]);
	}
}
