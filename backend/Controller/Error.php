<?php

namespace Admin\Controller;

class Error extends Controller
{
	public function methodIndex($args)
	{
		header("HTTP/1.0 404 Not Found");
		parent::render();
		return $this->view->render('templates/404.phtml', $args);
	}
}
