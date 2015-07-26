<?php

namespace Admin\Controller;

class Index extends \Core\Controller
{
	public function methodIndex($args)
	{
		return $this->view->render($this->_appPath . '/vendor/follower/admin/templates/base.phtml', []);
	}
}