<?php

namespace Admin\Controller;

class Controller extends \Core\Controller
{
	public function __construct()
	{
		parent::__construct();

		// set global path to public folder (for loading templates, and other resources)
		$this->view->setDefaultPath(
			'/vendor/follower/admin/public'
		);
	}

	public function render($data)
	{
		if (empty($data['styles'])) $data['styles'] = [];
		if (empty($data['scripts'])) $data['scripts'] = [];

		$data['styles'] = array_merge([
			'/bower_components/bootstrap/dist/css/bootstrap.min.css',
			'/bower_components/metisMenu/dist/metisMenu.min.css',
			'/dist/css/sb-admin-2.css',
			'/bower_components/font-awesome/css/font-awesome.min.css',
		], $data['styles']);

		$data['scripts'] = array_merge([
			'/bower_components/jquery/dist/jquery.min.js',
			'/bower_components/bootstrap/dist/js/bootstrap.min.js',
			'/bower_components/metisMenu/dist/metisMenu.min.js',
			'/dist/js/sb-admin-2.js',
		], $data['scripts']);

		return $this->view->render('templates/base.phtml', $data);
	}
}
