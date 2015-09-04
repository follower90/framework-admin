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



	////temporarily here
	////temporarily looks like shit
	////@todo
	public static function buildForm($controller, $values, $fields)
	{
		$result = '<form role="form" action="/admin/' . $controller . '/save">';
		$counter = 0;

		foreach ($fields as $data) {
			$field = $data['field'];
			$inputVal = $values[$field] ? ' value="' . $values[$field] . '"' : '' ;
			$counter++;

			switch ($data['type']) {
				case 'hidden':
					$result .= '<input type="hidden" name="id" ' . $inputVal . ' />';
					break;

				case 'input':
					$result .= '<div class="form-group">
				        <label>' . $data['name'] . '</label>
				        <input class="form-control" name="' . $field . '" ' . $inputVal . ' />
				    </div>';
					break;
				case 'textarea':
					$result .= '<div class="form-group">
					        <label>' . $data['name'] . '</label>
					        <textarea id="editor-' . $counter . '" class="form-control" name="' . $field . '">' . ($values[$field] ? ' ' . $values[$field] : '' ) . '</textarea>
					        <script>CKEDITOR.replace(\'editor-' . $counter . '\');</script>
					    </div>';
					break;

				case 'selectize':
					$result .= '
					<div class="form-group">
						<label>' . $data['name'] . '</label>
						<select name="' . $data['name'] . '" id="selectize-' . $counter . '" multiple>
							<option value="1">pages-edit</option>
							<option value="2" selected>pages-view</option>
						</select>
					</div>
						<script>$("#selectize-' . $counter . '").selectize({
							plugins: [\'remove_button\']
						});</script>';
			}
		}

		$result .= '<div class="form-group">
		        <input type="submit" class="btn btn-default" value="Save" />
		        <input type="button" class="btn btn-cancel"
		        onclick="location.href=\'/admin/' . $controller . '\';" value="Cancel" />
		    </div>';



		$result .= '</form>';

		return $result;
	}
}
