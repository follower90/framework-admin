<?php

namespace App\Controller;

use Admin\Object\Menu;
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

		$this->view->setNoticeObject('\App\Notice');
		$this->view->setDefaultPath('public/fashion');
	}

	public function render($data = [])
	{
		$data['user'] = $this->user;
		$data['languages'] = Config::getAvailableLanguages();
		$data['currencies'] = \Core\Orm::find('Currency')->getData();

		$data['currency'] = \Core\Orm::load('Currency', \Core\Config::get('site.currency'))->getValue('symbol');

		$data['meta'] = Meta::getData();

		$controllerNameChunks = explode('\\', get_called_class());
		$data['controller'] = array_pop($controllerNameChunks);

		$data['main_menu'] = \Core\Orm::find('Menu', ['active', 'type'], [1, Menu::TYPE_MAIN], ['sort' => ['sort', 'desc']])->getData();
		$data['bottom_menu'] = \Core\Orm::find('Menu', ['active', 'type'], [1, Menu::TYPE_BOTTOM], ['sort' => ['sort', 'desc']])->getData();
		$data['catalogs'] = \Core\Orm::find('Catalog', ['active'], [1])->getData();

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
			'/css/bootstrap.min.css',
			'/css/responsive.css',
			'/css/font-awesome/css/font-awesome.min.css',
			'/css/magnific-popup.css',
			'/css/style.css'
		]);

		$this->addJavaScriptPath([
			'/js/jquery-1.11.1.min.js',
			'/js/jquery-migrate-1.2.1.min.js',
			'/js/bootstrap.min.js',
			'/js/ie8-responsive-file-warning.js',
			'/js/bootstrap-hover-dropdown.min.js',
			'/js/jquery.magnific-popup.min.js',
			'/js/custom.js',
			'/js/cart.js',
			'/js/favourite.js',
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
