<?php

namespace Admin\Controller;

use \Core\Router;
use \Core\View;

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

		$this->view->setDefaultPath('public/admin');
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
			'/css/bootstrap.min.css',
			'/css/bootstrap-switch.min.css',
			'/css/sb-admin-2.css',
			'/css/font-awesome.min.css',
			'/css/selectize.bootstrap3.css',
		]);

		$this->addJavaScriptPath([
			'/js/jquery.min.js',
			'/js/bootstrap.min.js',
			'/js/bootstrap-switch.min.js',
			'/js/sb-admin-2.js',
			'/js/plugin/ckeditor/ckeditor.js',
			'/js/selectize.min.js',
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
