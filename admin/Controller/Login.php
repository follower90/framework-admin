<?php

namespace Admin\Controller;

use Admin\Object\Admin;
use Core\Router;

class Login extends Controller
{
	private $_authorize = false;

	public function __construct()
	{
		parent::__construct();
		$this->_authorize = new \Admin\Authorize('Admin');
	}

	public function methodIndex($args)
	{
		if (isset($args['login'], $args['password'])) {
			$remember = isset($args['remember']) ? true : false;

			$hash = function($password) {
				return Admin::hashPassword($password);
			};

			$this->_authorize->login($args['login'], $args['password'], $hash, $remember);

			if (!$this->_authorize->getUser()) {
				$this->view->addNotice('error', 'Incorrect login or password');
			} else {
				Router::redirect('/admin');
			}
		}

		return $this->renderPage('templates/login.phtml');
	}
}
