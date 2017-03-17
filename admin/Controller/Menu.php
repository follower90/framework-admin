<?php

namespace Admin\Controller;

use Core\Orm;
use Core\Router;

use Admin\Paging;

class Menu extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$filter = \Admin\Filter::init('menu');
		$filter->setFilters($args);

		$type = $filter->getFilter('type') ? $filter->getFilter('type') : \Admin\Object\Menu::TYPE_MAIN;

		$paging = Paging::create('Menu', [
			'page_size' => 20,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page'],
			'params' => [['type'], [$type]]
		]);

		$data['types'] = \Admin\Object\Menu::getTypesMap();
		$data['filter'] = $filter->getFilters();
		$data['paging'] = $paging->getPaging();
		$data['menu'] = $paging->getObjects(true);

		$data['content'] = $this->view->render('templates/modules/menu/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['all'] = Orm::find('Menu', ['active'], [1])->getData();
		$data['content'] = $this->view->render('templates/modules/menu/add.phtml', ['types' => \Admin\Object\Menu::getTypesMap()]);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$data['menu'] = Orm::load('Menu', $args['edit'])->getValues();
		$data['all'] = Orm::find('Menu', ['active'], [1])->getData();
		$data['types'] = \Admin\Object\Menu::getTypesMap();
		$data['content'] = $this->view->render('templates/modules/menu/edit.phtml', $data);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		$this->checkWritePermissions();
		if (!empty($args['id'])) {
			$menu = Orm::load('Menu', $args['id']);
		} else {
			$menu = Orm::create('Menu');
		}

		try {
			$menu->updateAttributes($args);
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
		$this->checkWritePermissions();
		$page = Orm::load('Menu', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$menu = Orm::create('Menu');
		$menu->updateAttributes($data);

		Router::redirect('/admin/menu/');
	}

	public function methodDelete($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('Menu', $args['delete']);

		Orm::delete($page);
		$this->back();
	}
}
