<?php

namespace Admin\Controller;

use Core\Router;

class Logout extends Controller
{
	private $_authorize = false;

	public function __construct()
	{
		parent::__construct();
		$this->_authorize = new \Admin\Authorize('Admin');
	}

	public function methodIndex()
	{
		$this->_authorize->logout();
		Router::redirect('/admin/login');
	}
}
