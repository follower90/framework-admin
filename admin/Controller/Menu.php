<?php

namespace Admin\Controller;

use \Core\View\Paging;
use \Core\Orm;
use \Core\Router;

class Menu extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('Menu', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['menu'] = $paging->getObjects(true);

		$data['content'] = $this->view->render('templates/modules/menu/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/menu/add.phtml', ['types' => \Admin\Object\Menu::getTypesMap()]);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$data['menu'] = Orm::load('Menu', $args['edit'])->getValues();
		$data['types'] = \Admin\Object\Menu::getTypesMap();
		$data['content'] = $this->view->render('templates/modules/menu/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$menu = Orm::load('Menu', $args['id']);
		} else {
			$menu = Orm::create('Menu');
		}

		$menu->setValues($args);

		try {
			Orm::save($menu);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($menu->isNew()) {
				Router::redirect('/admin/menu/new');
			}
		}

		Router::redirect('/admin/menu/edit/' . $menu->getId());
	}

	public function methodDuplicate($args)
	{
		$page = Orm::load('Menu', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('Menu');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/menu/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('Menu', $args['delete']);

		Orm::delete($page);
		Router::redirect('/admin/menu/');
	}
}
