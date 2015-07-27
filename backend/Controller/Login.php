<?php

namespace Admin\Controller;

use \Admin\Object\Admin;
use \Core\Authorizer;
use \Core\Router;

class Login extends Controller
{
	private $_authorize = false;

	public function __construct()
	{
		parent::__construct();
		$this->_authorize = new \Core\Authorize('Admin');
	}

	public function methodIndex($args)
	{
		if ($this->_user) {
			Router::redirect('/admin');
		}

		if (isset($args['login'], $args['password'])) {
			$this->login();
		}

		$this->prepareResources();

		$data['styles'] = $this->_styles;
		$data['scripts'] = $this->_scripts;

		return $this->view->render('templates/login.phtml', $data);
	}

	public function login()
	{
		$this->_authorize->login($this->request('login'), $this->request('password'),
			function($password) {
				return Admin::hashPassword($password);
			}
		);

		if (!$this->_authorize->getUser()) {
			$this->view->addNotice('error', 'error', 'Incorrect Password');
		}
	}
	
	public function logout()
	{
		$this->_authorize->logout();
		Router::redirect('/admin/login');
	}
}
