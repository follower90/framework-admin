<?php

namespace Admin\Controller;

use Core\Config;
use Core\Router;
use Core\View;

class Controller extends \Core\Controller
{
	protected $_scripts = [];
	protected $_styles = [];
	protected $_data = [];

	public function __construct()
	{
		parent::__construct();
		$this->checkReadPermissions();
		$this->prepareResources();

		$this->view->setDefaultPath('public/admin');
		$this->view->setNoticeObject('\Admin\Notice');
	}

	public function render($data = [])
	{
		$this->_data = array_merge($this->_data, $data);
		$this->_data['user'] = $this->user;
		$this->_data['modules'] = \Admin\Service\Module::getAvailableModules()->getData();
		$this->_data['languages'] = Config::getAvailableLanguages();

		if (!$this->user) {
			if (Router::get('uri') != '/admin/login') {
				Router::redirect('/admin/login');
			}

			return $this->view->render('templates/login.phtml', $this->_data);
		}

		return $this->view->render('templates/base.phtml', $this->_data);
	}

	protected function checkReadPermissions()
	{
		if (!\Admin\Service\Module::isAvailableFor(\Admin\Object\Admin_Group_Permission::VIEW)) {
			$this->render404();
		}
	}

	protected function checkWritePermissions()
	{
		if (!\Admin\Service\Module::isAvailableFor(\Admin\Object\Admin_Group_Permission::MANAGE)) {
			$this->render404();
		}
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
		$this->_scripts = array_merge($this->_scripts, $paths);
		$this->_data['scripts'] = $this->_scripts;
	}

	public function addCssPath($paths = [])
	{
		if (!is_array($paths)) $paths = [$paths];

		$this->_styles = array_merge($this->_styles, $paths);
		$this->_data['styles'] = $this->_styles;
	}

	public function render404()
	{
		Router::redirect('/admin/404', Router::NOT_FOUND_404);
	}
}
