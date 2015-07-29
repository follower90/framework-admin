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
			$remember = isset($args['remember']) ? true : false;
			$hash = function($password) {
				return Admin::hashPassword($password);
			};

			$this->_authorize->login($this->request('login'), $this->request('password'), $hash, $remember);

			if (!$this->_authorize->getUser()) {
				$this->view->addNotice('danger', 'Incorrect Password');
			} else {
				Router::redirect('/admin');
			}
		}

		$this->prepareResources();

		$data['styles'] = $this->_styles;
		$data['scripts'] = $this->_scripts;

		return $this->view->render('templates/login.phtml', $data);
	}

	public function methodLogout()
	{
		$this->_authorize->logout();
		Router::redirect('/admin/login');
	}
}
