<?php

namespace Admin\Controller;

class Page extends Controller
{
	public function methodIndex($args)
	{
		$data['content'] = $this->view->render('templates/pages/index.phtml', []);
		return $this->render($data);
	}
}
