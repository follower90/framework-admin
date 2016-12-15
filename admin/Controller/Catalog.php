<?php

namespace Admin\Controller;

use Core\View\Paging;
use Core\Orm;
use Core\Router;

class Catalog extends Controller
{
	public function methodIndex($args)
	{
		$data = [];
		$parentId = $args['parent'] ? (int)$args['parent'] : null;

		$paging = Paging::create('Catalog', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page'],
			'params' => [['parent'], [$parentId]]
		]);

		$data['paging'] = $paging->getPaging();
		$data['catalogs'] = $paging->getObjects();
		$data['all'] = Orm::find('Catalog', ['active'], [1])->getData();
		$data['current'] = $parentId;
		$data['content'] = $this->view->render('templates/modules/catalog/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$all = Orm::find('Catalog', ['active'], [1])->getData();
		$data['content'] = $this->view->render('templates/modules/catalog/add.phtml', ['all' => $all]);
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$catalog = Orm::load('Catalog', $args['edit'])->getValues();
		$all = Orm::find('Catalog', ['active', '!id'], [1, $args['edit']])->getData();
		$data['content'] = $this->view->render('templates/modules/catalog/edit.phtml', ['catalog' => $catalog, 'all' => $all]);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		$this->checkWritePermissions();
		if (!empty($args['id'])) {
			$catalog = Orm::load('Catalog', $args['id']);
		} else {
			$catalog = Orm::create('Catalog');
		}

		$catalog->setValues($args);

		try {
			Orm::save($catalog);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($catalog->isNew()) {
				Router::redirect('/admin/catalog/new');
			}
		}

		Router::redirect('/admin/catalog/edit/' . $catalog->getId());
	}

	public function methodDuplicate($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('Catalog', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('Catalog');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/catalog/');
	}

	public function methodDelete($args)
	{
		$this->checkWritePermissions();
		$page = Orm::load('Catalog', $args['delete']);

		Orm::delete($page);
		Router::redirect('/admin/catalog/');
	}
}
