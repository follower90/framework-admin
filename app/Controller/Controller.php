<?php

namespace App\Controller;

use Core\Config;
use Core\Router;

class Controller extends \Core\Controller
{
	protected $_scripts = [];
	protected $_styles = [];
	protected $_data = [];
	protected $_user = false;

	public function __construct()
	{
		parent::__construct();

		$authorize = new \Core\Authorize('User');
		$this->_user = $authorize->getUser();

		$this->prepareResources();

		$this->view->setDefaultPath('public/app');
	}

	public function render($data = [])
	{
		$data['user'] = $this->_user;
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
		$this->addCssPath(['/css/bootstrap.min.css']);
		$this->addJavaScriptPath([]);
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
