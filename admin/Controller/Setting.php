<?php

namespace Admin\Controller;

use \Core\View\Paging;
use \Core\Orm;
use \Core\Router;

class Setting extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Setting', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['settings'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/setting/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/setting/add.phtml');
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$setting = Orm::load('Setting', $args['edit'])->getValues();
		$data['content'] = $this->view->render('templates/modules/setting/edit.phtml', ['setting' => $setting]);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		$setting = \Admin\Object\Setting::put($args['key'], $args['value']);
		Router::redirect('/admin/setting/edit/' . $setting->getId());
	}

	public function methodDuplicate($args)
	{
		$page = Orm::load('Setting', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('Setting');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/setting/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('Setting', $args['delete']);

		Orm::delete($page);
		Router::redirect('/admin/setting/');
	}
}
