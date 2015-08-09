<?php

namespace Admin\Controller;

class Page extends Controller
{
	public function methodIndex($args)
	{
		$data = [];
		$data['onpage'] = 10;

		if (isset($args['page'])) {
			$data['offset'] = ((int)$args['page'] - 1) * $data['onpage'];
			$data['limit'] = $data['onpage'];
		}

		$data['page'] = (int)$args['page'];
		$data['pages'] = \Core\Orm::find('Page', [], [], $data)->getData();
		$data['total'] = \Core\Orm::count('Page', [], []);

		$data['content'] = $this->view->render('templates/pages/index.phtml', $data);

		$this->addCssPath([
			'/bower_components/datatables-responsive/css/dataTables.responsive.css',
			'/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css',
		]);

		return $this->render($data);
	}

	public function methodAdd($args)
	{
		$data['content'] = $this->view->render('templates/pages/add.phtml', []);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$data['page'] = \Core\Orm::load('Page', $args['id'])->getValues();
		$data['content'] = $this->view->render('templates/pages/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$page = \Core\Orm::load('Page', $args['id']);
		} else {
			$page = \Core\Orm::create('Page');
		}

		$page->setValues($args);
		\Core\Orm::save($page);

		\Core\Router::redirect('/admin/page/edit?id=' . $page->getId());
	}

	public function methodDelete($args)
	{
		$page = \Core\Orm::load('Page', $args['id']);

		\Core\Orm::delete($page);
		\Core\Router::redirect('/admin/page/');
	}
}