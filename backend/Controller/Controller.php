<?php

namespace Admin\Controller;

use \Core\Router;

class Controller extends \Core\Controller
{
	protected $_scripts = [];
	protected $_styles = [];

	protected $_data = [];

	protected $_user = false;

	public function __construct()
	{
		parent::__construct();

		$authorize = new \Core\Authorize('Admin');
		$this->_user = $authorize->getUser();

		$this->prepareResources();

		// set global path to public folder (for loading templates, and other resources)
		$this->view->setDefaultPath('/vendor/follower/admin/public');

		// set object for rendering notices
		$this->view->setNoticeObject('\Admin\Notice');
	}

	public function render($data = [])
	{
		$this->_data = array_merge($this->_data, $data);

		if (!$this->_user) {
			if (Router::get('uri') != '/admin/login') {
				Router::redirect('/admin/login');
			}

			return $this->view->render('templates/login.phtml', $this->_data);
		}
		
		return $this->view->render('templates/base.phtml', $this->_data);
	}

	public function renderPage($template, $data = [])
	{
		$this->prepareResources();

		$this->_data = array_merge($this->_data, $data);
		return $this->view->render($template, $this->_data);
	}

	protected function prepareResources()
	{
		$this->addCssPath([
			'/bower_components/bootstrap/dist/css/bootstrap.min.css',
			'/bower_components/metisMenu/dist/metisMenu.min.css',
			'/dist/css/sb-admin-2.css',
			'/bower_components/font-awesome/css/font-awesome.min.css',
		]);

		$this->addJavaScriptPath([
			'/bower_components/jquery/dist/jquery.min.js',
			'/bower_components/bootstrap/dist/js/bootstrap.min.js',
			'/bower_components/metisMenu/dist/metisMenu.min.js',
			'/dist/js/sb-admin-2.js',
		]);
	}

	protected function addJavaScriptPath($paths = [])
	{
		if (!is_array($paths)) $paths = [$paths];
		$this->_scripts = array_merge($paths, $this->_scripts);
		$this->_data['scripts'] = $this->_scripts;
	}

	public function addCssPath($paths = [])
	{
		if (!is_array($paths)) $paths = [$paths];

		$this->_styles = array_merge($paths, $this->_styles);
		$this->_data['styles'] = $this->_styles;
	}
}
