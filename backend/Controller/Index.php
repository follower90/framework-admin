<?php

namespace Admin\Controller;

class Index extends \Core\Controller
{
	public function methodIndex($args)
	{
		return $this->view->render('../vendor/follower/admin/public/templates/base.phtml', []);
	}
}