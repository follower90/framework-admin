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

	public function render($args)
	{
		return $this->view->render('templates/base.phtml', $args);
	}
}
