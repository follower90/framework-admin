<?php

namespace Admin\Controller;

class Page extends Controller
{
	public function methodIndex($args)
	{
		$data['pages'] = \Core\Orm::find('Page')->getData();

		$data['content'] = $this->view->render('templates/pages/index.phtml', $data);

		$this->addCssPath([
			'/bower_components/datatables-responsive/css/dataTables.responsive.css',
			'/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css',
		]);

		return $this->render($data);
	}
}
