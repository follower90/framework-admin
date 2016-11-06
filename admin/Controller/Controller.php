<?php

namespace Admin\Controller;

use \Core\Router;
use Core\View;

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
			'/bower_components/bootstrap/dist/css/bootstrap.min.css',
			'/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
			'/bower_components/metisMenu/dist/metisMenu.min.css',
			'/dist/css/sb-admin-2.css',
			'/bower_components/font-awesome/css/font-awesome.min.css',
			'/bower_components/datatables-responsive/css/dataTables.responsive.css',
			'/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css',
			'/bower_components/selectize/dist/css/selectize.bootstrap3.css',
		]);

		$this->addJavaScriptPath([
			'/bower_components/jquery/dist/jquery.min.js',
			'/bower_components/bootstrap/dist/js/bootstrap.min.js',
			'/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js',
			'/bower_components/metisMenu/dist/metisMenu.min.js',
			'/dist/js/sb-admin-2.js',
			'/plugin/ckeditor/ckeditor.js',
			'/bower_components/selectize/dist/js/standalone/selectize.min.js',
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

	public static function buildForm($controller, $values, $fields)
	{
		$view = new \Core\View();
		$view->setDefaultPath('public/admin');

		$formFields = [];
		$counter = 1;

		foreach ($fields as $data) {
			$params = [
				'count' => $counter,
				'field' => $data['field'],
				'name' => isset($data['name']) ? $data['name'] : '',
				'options' => isset($data['options']) ? $data['options'] : [],
				'value' => isset($values[$data['field']]) ? $values[$data['field']] : ''
			];

			$formFields[] = $view->render('templates/snippet/form/' . $data['type'] . '.phtml', $params);
			$counter++;
		}

		return $view->render('templates/snippet/form/form.phtml', ['controller' => $controller, 'fields' => $formFields]);
	}
}
