<?php

namespace Admin\Controller;

use Core\View\Paging;
use Core\Orm;
use Core\Router;

class Filter extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$paging = Paging::create('FilterSet', [
			'page_size' => 10,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page']
		]);

		$data['paging'] = $paging->getPaging();
		$data['filters'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/filter/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/filter/add.phtml');
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$set = Orm::load('FilterSet', $args['edit']);
		$filters = Orm::find('Filter', ['filterSetId'], [$set->getId()])->getData();
		$data['content'] = $this->view->render('templates/modules/filter/edit.phtml', ['filter' => $set->getValues(), 'filters' => $filters]);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		$this->checkWritePermissions();
		if (!empty($args['id'])) {
			$filter = Orm::load('FilterSet', $args['id']);
		} else {
			$filter = Orm::create('FilterSet');
		}

		$filter->setValues($args);

		try {
			Orm::save($filter);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($filter->isNew()) {
				Router::redirect('/admin/filter/new');
			}
		}

		Router::redirect('/admin/filter/edit/' . $filter->getId());
	}

	public function methodSavefilters($args)
	{
		$filterSet = Orm::load('FilterSet', $args['set_id']);

		$ids = [];
		$i = 0;

		foreach ($args['name'] as $name) {
			if (empty($name)) continue;

			$id = $args['id'][$i];

			$filter = $id ? Orm::load('Filter', $id) : Orm::create('Filter');
			$filter->setValues([
				'name' => $name,
				'filterSetId' => $filterSet->getId()
			]);

			$filter->save();
			array_push($ids, $filter->getId());
			$i++;
		}

		Orm::find('Filter', ['filterSetId', '!id'], [$filterSet->getId(), $ids])->removeAll();
		Router::redirect('/admin/filter/edit/' . $filterSet->getId());
	}

	public function methodDuplicate($args)
	{
		$page = Orm::load('FilterSet', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('FilterSet');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/filter/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('FilterSet', $args['delete']);

		Orm::delete($page);
		Router::redirect('/admin/filter/');
	}
}
