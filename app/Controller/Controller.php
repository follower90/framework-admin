<?php

namespace App\Controller;

use App\Service\Meta;
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
		$data['currencies'] = \Core\Orm::find('Currency')->getData();
		$data['meta'] = Meta::getData();

		$data['main_menu'] = \Core\Orm::find('Menu', ['active'], [1], ['sort' => ['sort', 'desc']])->getData();

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
		$result = '<li><a href="/">'. __('Main').'</a></li>';

		if (sizeof($data) > 0) {
			$last = array_pop($data);
		}

		foreach ($data as $val) {
			$result .= '<li><a href=' . $val['url'] .'>' . $val['name']. '</a></li>';
		}

		$result .= '<li class="active">'. $last['name'] . '</li>';
		return '<ol class="breadcrumb">' . $result . '</ol>';
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
		$this->_styles = array_merge($paths, $this->_styles);
		$this->_data['styles'] = $this->_styles;
	}

	public function render404()
	{
		Router::redirect('/404', Router::NOT_FOUND_404);
	}

	public function back() {
		Router::redirect(Router::get('referer'));
	}
}
