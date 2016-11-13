<?php

namespace Admin\Controller;

use \Core\View\Paging;
use \Core\Orm;
use \Core\Router;

class Translation extends Controller
{
	public function methodIndex($args)
	{
		$data = [];

		$filter = \Admin\Filter::init('translation');
		$filter->setFilters($args);

		$type = $filter->getFilter('type') ? $filter->getFilter('type') : 'admin';

		$paging = Paging::create('Translation', [
			'page_size' => 30,
			'current_page' => empty($args['page']) ? 1 : (int)$args['page'],
			'params' => [['type'], [$type]]
		]);

		$data['filter'] = $filter->getFilters();
		$data['paging'] = $paging->getPaging();
		$data['translations'] = $paging->getObjects();

		$data['content'] = $this->view->render('templates/modules/translation/index.phtml', $data);

		return $this->render($data);
	}

	public function methodNew()
	{
		$data['content'] = $this->view->render('templates/modules/translation/add.phtml');
		return $this->render($data);
	}

	public function methodEdit($args)
	{
		$translation = Orm::load('Translation', $args['edit'])->getValues();
		$data['content'] = $this->view->render('templates/modules/translation/edit.phtml', ['translation' => $translation]);

		return $this->render($data);
	}

	public function methodSave($args)
	{
		if (!empty($args['id'])) {
			$translation = Orm::load('Translation', $args['id']);
		} else {
			$translation = Orm::create('Translation');
		}

		$translation->setValues($args);

		try {
			Orm::save($translation);
		} catch (\Core\Exception\UserInterface\ObjectValidationException $e) {
			$this->view->addNotice('error', $e->getMessage());
			if ($translation->isNew()) {
				Router::redirect('/admin/translation/new');
			}
		}

		Router::redirect('/admin/translation/edit/' . $translation->getId());
	}

	public function methodDuplicate($args)
	{
		$page = Orm::load('Translation', $args['duplicate']);
		$data = $page->getValues();
		unset($data['id']);

		$newPage = Orm::create('Translation');
		$newPage->setValues($data);
		Orm::save($newPage);

		Router::redirect('/admin/translation/');
	}

	public function methodDelete($args)
	{
		$page = Orm::load('Translation', $args['delete']);

		Orm::delete($page);
		Router::redirect('/admin/translation/');
	}
}