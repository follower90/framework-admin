<?php

namespace Admin\Controller;

class Controller extends \Core\Controller
{
	private $_scripts = [];
	private $_styles = [];

	public function __construct()
	{
		parent::__construct();

		// set global path to public folder (for loading templates, and other resources)
		$this->view->setDefaultPath('/vendor/follower/admin/public');
	}

	public function render($data)
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

		return $this->_render($data);
	}

	protected function addJavaScriptPath($paths = [])
	{
		if (!is_array($paths)) $paths = [$paths];
		$this->_scripts = array_merge($paths, $this->_scripts);
	}

	public function addCssPath($paths = [])
	{
		if (!is_array($paths)) $paths = [$paths];
		$this->_styles = array_merge($paths, $this->_styles);
	}

	private function _render($data)
	{
		$data['styles'] = $this->_styles;
		$data['scripts'] = $this->_scripts;

		return $this->view->render('templates/base.phtml', $data);
	}
}
