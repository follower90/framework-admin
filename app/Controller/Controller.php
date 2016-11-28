<?php

namespace App\Controller;

use Core\Config;
use Core\Router;

class Controller extends \Core\Controller
{
	protected $_scripts = [];
	protected $_styles = [];
	protected $_data = [];

	public function __construct()
	{
		parent::__construct();
		$this->prepareResources();

		$this->view->setDefaultPath('public/app');
	}

	public function render($data = [])
	{
		$data['user'] = $this->user;
		$data['languages'] = Config::getAvailableLanguages();

		$data['main_menu'] = \Core\Orm::find('Menu', ['active'], [1])->getData();

		$this->_data = array_merge($this->_data, $data);
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
			'/css/bootstrap.min.css'
		]);

		$this->addJavaScriptPath([
			'/js/jquery.min.js',
			'/js/bootstrap.min.js',
			'/js/cart.js',
			'/js/app.js'
		]);
	}

	protected function renderBreadCrumbs($data = [])
	{
		$result = '<li><a href="/">'. i18n('Main').'</a></li>';

		if (sizeof($data) > 0) {
			$last = array_pop($data);
		}

		foreach ($data as $key => $val) {
			$result .= '<li><a href=' . $val['url'] .'>' . $val['name']. '</a></li>';
		}

		$result .= '<li class="active">'. $last['name'] . '</li>';
		return '<ol class="breadcrumb">' . $result . '</ol>';
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

	public function render404()
	{
		Router::redirect('/404', Router::NOT_FOUND_404);
	}
}
