<?php

namespace Admin\Controller;

class Error extends Controller
{
	public function methodIndex()
	{
		$data['styles'] =[
			'/css/bootstrap.min.css',
			'/css/sb-admin-2.css',
			'/css/font-awesome.min.css',
		];

		header("HTTP/1.0 404 Not Found");
		return $this->renderPage('templates/404.phtml', $data);
	}
}
